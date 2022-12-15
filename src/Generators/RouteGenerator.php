<?php

namespace BawanehWeCan\Generator\Generators;

use Illuminate\Support\Facades\File;

class RouteGenerator
{
    /**
     * Generate a route on web.php.
     *
     * @param array $request
     * @return void
     */
    public function generate(array $request)
    {
        $model = GeneratorUtils::setModelName($request['model']);
        $path = GeneratorUtils::getModelLocation($request['model']);

        $modelNameSingularPascalCase = GeneratorUtils::singularPascalCase($model);
        $modelNamePluralLowercase = GeneratorUtils::pluralKebabCase($model);
        $modelNameSingularCamelCase = GeneratorUtils::singularCamelCase($model);



        $api = "\n\n\n\n\n\n" . "Route::get('" . $modelNamePluralLowercase . "', [App\Http\Controllers\\Api\\" . $modelNameSingularPascalCase . "Controller::class, 'list']);";
        $api .= "\n" . "Route::post('" . $modelNameSingularCamelCase . "-create', [App\Http\Controllers\\Api\\" . $modelNameSingularPascalCase . "Controller::class, 'save']);";
        $api .= "\n" . "Route::get('" . $modelNameSingularCamelCase . "/{id}', [App\Http\Controllers\\Api\\" . $modelNameSingularPascalCase . "Controller::class, 'view']);";
        $api .= "\n" . "Route::get('" . $modelNameSingularCamelCase . "/delete/{id}', [App\Http\Controllers\\Api\\" . $modelNameSingularPascalCase . "Controller::class, 'delete']);";
        $api .= "\n" . "Route::post('" . $modelNameSingularCamelCase . "/edit/{id}', [App\Http\Controllers\\Api\\" . $modelNameSingularPascalCase . "Controller::class, 'edit']);";


        if ($path != '') {
            $controllerClass = "\n" . "Route::resource('" . $modelNamePluralLowercase . "', App\Http\Controllers\\" . str_replace('/', '\\', $path) . "\\" . $modelNameSingularPascalCase . "Controller::class)->middleware('auth');";
        } else {
            $controllerClass = "\n" . "Route::resource('" . $modelNamePluralLowercase . "', App\Http\Controllers\\" . $modelNameSingularPascalCase . "Controller::class)->middleware('auth');";
        }

        File::append(base_path('routes/web.php'), $controllerClass);
        File::append(base_path('routes/api.php'), $api);
    }
}
