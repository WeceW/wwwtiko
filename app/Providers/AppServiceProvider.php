<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer(['session.task', 'session.feedback'], function($view) {
            $opiskelijat = DB::connection('pgsql2')->select('select * from opiskelijat');
            $kurssit = DB::connection('pgsql2')->select('select * from kurssit');
            $suoritukset = DB::connection('pgsql2')->select('select * from suoritukset');

            $view->with(compact('opiskelijat', 'kurssit', 'suoritukset'));
        });

        Validator::extend('start_with_sql_command', function($attribute, $value, $parameters, $validator) {

            $firstSixLetters = strtolower(substr($value, 0, 7));

            return $firstSixLetters == 'select ' || 
                   $firstSixLetters == 'insert ' ||
                   $firstSixLetters == 'update ' || 
                   $firstSixLetters == 'delete ';
        });

        Validator::extend('even_brackets', function($attribute, $value, $parameters, $validator) {
            return substr_count($value, '(') == substr_count($value, ')');
        });

        Validator::extend('semicolon_max', function($attribute, $value, $parameters, $validator) {
            return substr_count($value, ';') <= $parameters[0];
        });

        Validator::extend('semicolon_at_end', function($attribute, $value, $parameters, $validator) {
            return substr($value, -1) == ';';
        });



    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
