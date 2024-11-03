<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

//  _________________________________
// < Cuidado ao alterar este código! >
//  ---------------------------------
//         \   ^__^
//          \  (0X)\_______
//             (__)\       )\/\
//                 ||----w |
//                 ||     ||

/**
 * Classe helper genérica para faciliar a consulta de dados das models.
 *
 * Fornecendo os parametros base e a model que irá fazer a busca a classe devolve uma coleção.
 *
 * @var \DateTime $date_start
 * @var \DateTime $date_end
 * @var boolean $use_time_start
 * @var boolean $use_time_end
 * @var string $date_field
 * @var string $sortby_keyword
 * @var string $sortby_order
 * @var number $limit
 * @var array $columns
 */
class QueryHelper
{
    /**
     * @param array $params Os parametros vindos da URL.
     * @param Model $model A Model que irá fazer a busca dos registros.
     * @param array $filters Filtros de seleção da cláusula where.
     */
    public function __invoke($params, $model, $filters = [])
    {
        $this->validateParams($params);

        [
            "date_start" => $date_start,
            "date_end" => $date_end,
            "date_field" => $date_field,
            "sortby_keyword" => $sortby_keyword,
            "sortby_order" => $sortby_order,
            "limit" => $limit,
            "columns" => $columns,
            "trashed" => $trashed
        ] = $params;

        $tablename = Str::snake(explode("App\\Models\\", $model)[1]);

        if (!is_null(Auth::user()) && Schema::hasColumn($tablename, "user_id")) {
            array_push($filters, ["user_id", Auth::id()]);
        }

        if ($trashed === true) {
            return $model::onlyTrashed()->where($filters)
                ->whereBetween($date_field, [$date_start, $date_end])
                ->orderBy($sortby_keyword, $sortby_order)
                ->limit($limit)
                ->get($columns);
        }

        return $model::where($filters)
            ->whereBetween($date_field, [$date_start, $date_end])
            ->orderBy($sortby_keyword, $sortby_order)
            ->limit($limit)
            ->get($columns);
    }

    /**
     * Um helper para a classe, faz uma tratativa dos parametros da URL.
     *
     * @param mixed $params Os parametros vindos da URL.
     */
    private function validateParams(&$params): void
    {
        $formatStart = $params["use_time_start"] ? "Y-m-d H:i:s" : "Y-m-d 00:00:00";
        $formatEnd = $params["use_time_end"] ? "Y-m-d H:i:s" : "Y-m-d 23:59:59";

        $params["date_start"] = date_create($params["date_start"])->format($formatStart);
        $params["date_end"] = date_create($params["date_end"])->format($formatEnd);
        $params["columns"] = explode(",", $params["columns"]);
        $params["trashed"] = filter_var($params["trashed"], FILTER_VALIDATE_BOOLEAN);
    }
}
