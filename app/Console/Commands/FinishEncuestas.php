<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Mail;
use Carbon\Carbon;
use App\Encuesta;
use App\EncuestaEstado;

class FinishEncuestas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encuestas:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finaliza las encuestas que cumplieron la fecha de vigencia.';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $hayPend = false;
        $encuestas = Encuesta::where('ENCU_PLANTILLA', false)
                                ->where('ENCUESTAS.ENES_ID', EncuestaEstado::PUBLICADA)
                                ->get();

        foreach ($encuestas as $encuesta) {

            $ENCU_FECHAVIGENCIA = Carbon::instance(new \DateTime($encuesta->ENCU_FECHAVIGENCIA))->second(0);
            $ahora = Carbon::now()->second(0);
            $strInfo = 'Encuesta '.$encuesta->ENCU_ID;

            //Si la fecha de vigencia de la encuesta es menor a la fecha actual...
            if($ENCU_FECHAVIGENCIA < $ahora ){
                $encuesta->ENES_ID = EncuestaEstado::FINALIZADA;
                $encuesta->save();

                //Enviar correo al creador de la encuesta
                $this->sendEmailAlert($encuesta, 'emails.alert_encuesta_cerrada', 'finalizada');

                $this->info($strInfo.' finalizada.');
                $hayPend = true;
            }
            //Si la vigencia de la encuesta caduca en 1 día...
            elseif ($ENCU_FECHAVIGENCIA->eq($ahora->addDay())) {
                //Enviar correo al creador de la encuesta
                $this->info($strInfo.' finalizará en 24 horas.');
                $this->sendEmailAlert($encuesta, 'emails.alert_encuesta_proxima_cerrar', 'próxima a finalizar');
            }
            
        }

        if(!$hayPend){
            $this->info('No hay encuestas para finalizar.');
        }
    }



    private function sendEmailAlert($encuesta, $view, $asunto)
    {
        //se envia el array y la vista lo recibe en llaves individuales {{ $email }} , {{ $subject }}...
        \Mail::send($view, compact('encuesta'), function($message) use ($encuesta, $asunto){

            //Se obtiene el usuario que creó la encuesta
            $user = \App\User::where('username', $encuesta->ENCU_CREADOPOR)
                                    ->get()->first();

            dump($user->name, $user->email);
            //remitente
            $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
            //asunto
            $message->subject('Encuesta '.$encuesta->ENCU_ID.' '.$asunto);
            //receptor
            $message->to($user->email, $user->name);
        });
    }
}
