<?php



if (function_exists('company') === false) {
    function company()
    {
      $currentUser=app('Modules\User\Contracts\Authentication')->user();
        $companies= app('Modules\Sass\Repositories\CompanyRepository');

        if (request()->session()->exists('company')){
            $company= $companies->find(request()->session()->get('company'));
        }else{
            $company=json_decode(json_encode(['name'=>'Seleccione una empresa','id'=>null]));
        }

        return $company;
    }
}
if (function_exists('companies') === false) {
    function companies()
    {
      $currentUser=app('Modules\User\Contracts\Authentication')->user();
        $companies= app('Modules\Sass\Repositories\CompanyRepository');
        if ($currentUser->hasAccess('sass.companies.indexall')){
            return  $companies->all();
        }else{
            return $currentUser->companies;
        }
    }
}
