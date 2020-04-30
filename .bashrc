# laravel new-app
alias laravel="git clone -o laravel -b develop https://github.com/laravel/laravel.git"

# Artisan
alias art="php artisan"
alias art:mig="art migrate"
alias art:reset="art migrate:reset"
alias art:fresh="art migrate:fresh --seed"
alias art:refresh="art migrate:refresh --seed"
alias art:rollback="art migrate:rollback"
alias art:schedule="art schedule:run"
alias art:seed="art db:seed --class="

alias art:jobs="art queue:work --sleep=3 --tries=3 --daemon"

alias art:dump="art dump autoload"
alias art:cac="art cache:clear"
alias art:vc="art view:clear"
alias art:rc="art route:clear"
alias art:opt="art optimize"
alias art:cls="art clear-compiled && art cache:clear && art view:clear && art route:clear && art optimize && art debugbar:clear && art:dump"

# phpunit
alias t="vendor/bin/phpunit --debug"

# Git
alias ga="git add"
alias gaa="git add ."
alias gc="git commit -m"
alias gps="git push"
alias gp="git pull"
alias gs="git status"
alias gl="git log --stat=100 --stat-graph-width=12"
alias gdiscard="git clean -df && git checkout -- ."
alias setpass="git config --global credential.helper wincred"

#Console
alias cls="clear"

#Composer
alias comp:up="composer.phar self-update"
alias comp:dump="composer dump-autoload"