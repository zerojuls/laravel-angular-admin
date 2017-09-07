<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class ClientController extends Controller
{
    public $storagePath = 'uploads/cms/clients';

    /**
     *
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Request $request)
    {
        $limit = is_numeric($request->input('limit')) ? $request->input('limit') : null;
        $model = Client::paginate($limit);

        return response()->returnJson($model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $exception = null;
        $http_code = HttpResponse::HTTP_OK;

        $this->validate($request, (new Client())->rules);

        try {
            $path = $this->upload($request, 'img_trademark');
            $model = Client::create(array_merge($request->all(), ['img_trademark' => $path]));

        } catch (ModelNotFoundException $exception) {
            $http_code = HttpResponse::HTTP_INTERNAL_SERVER_ERROR;
            $model = [];

        }

        return response()->returnJson($model, $exception, $http_code);
    }

    private function upload(Request $request, $field)
    {
        $path = ($request->hasFile($field)) ? $request->file($field)->store($this->storagePath) : null;

        return $path;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        $exception = null;
        $http_code = HttpResponse::HTTP_OK;

        try {
            $model = Client::findOrFail($id);
            $model->img_trademark = url($model->img_trademark);

        } catch (ModelNotFoundException $exception) {
            $http_code = HttpResponse::HTTP_NO_CONTENT;
            $model = [];

        }

        return response()->returnJson($model, $exception, $http_code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $exception = null;
        $http_code = HttpResponse::HTTP_OK;

        $this->validate($request, (new Client())->rules);

        try {
            $path = $this->upload($request, 'img_trademark');

            $model = Client::where("id", $id)->firstOrFail();
            $model->img_trademark = (empty($path) ? $model->img_trademark : $path);
            $model->fill(array_merge($request->all(), ['img_trademark' => $path]))->save();

        } catch (ModelNotFoundException $exception) {
            $http_code = HttpResponse::HTTP_INTERNAL_SERVER_ERROR;
            $model = [];

        }

        return response()->returnJson($model, $exception, $http_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $exception = null;
        $http_code = HttpResponse::HTTP_OK;

        try {
            $model = Client::where("id", $id)->firstOrFail();
            $model->delete();

        } catch (ModelNotFoundException $exception) {
            $http_code = HttpResponse::HTTP_NO_CONTENT;
            $model = [];

        }

        return response()->returnJson($model, $exception, $http_code);
    }
}
