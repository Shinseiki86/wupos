@extends('emails/layout')
@section('title', '- Encuesta')

@section('tituloMensaje')
  <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #8bc34a; margin: 0; padding: 20px;" align="center" bgcolor="#8bc34a" valign="top">
    {{ 'Encuesta '.$encuesta->ENCU_ID.' finalizada' }}
  </td>
@endsection

@section('mensaje')

  <table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
      <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
      La encuesta <strong style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">"{{$encuesta->ENCU_TITULO}}"</strong> finalizó el {{ date_format(new DateTime($encuesta->ENCU_FECHAVIGENCIA), Config::get('view.formatDateTime')) }}.
      </td>
    </tr>

    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
      <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" valign="top">
        <a href="{{ Config::get('app.url').'/encuestas/'.$encuesta->ENCU_ID.'/reportes/loading' }}" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;" target="_blank">
          Ver reporte
        </a>
      </td>
    </tr>

    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
      <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
        <div class="footer">
          <div style="color:#606060; padding-right:20px; text-align:right;">
            <small>Powered by <i>Shinseiki86</i></small>
          </div>
        </div>
      </td>
    </tr>

  </table>

@endsection