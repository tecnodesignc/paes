<?php



if (function_exists('company') === false) {
    function company()
    {
      $currentUser=app('Modules\User\Contracts\Authentication')->user();
        $companies= app('Modules\Sass\Repositories\CompanyRepository');

        if (request()->session()->exists('company')){
            $company= $companies->find(request()->session()->get('company'));
        }elseif ($currentUser->hasAccess('sass.companies.indexall')){
            $company=json_decode(json_encode(['name'=>'Seleccione una Empresa','id'=>null]));
        }else{
            $company=$currentUser->companies()->first();
            if ($company)
            request()->session()->put('company',$company->id);
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
