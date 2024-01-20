<?php

namespace Modules\Apigpswox\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Apigpswox\Entities\Token;
use Modules\Apigpswox\Http\Requests\CreateTokenRequest;
use Modules\Apigpswox\Http\Requests\UpdateTokenRequest;
use Modules\Apigpswox\Repositories\TokenRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TokenController extends AdminBaseController
{
    /**
     * @var TokenRepository
     */
    private $token;

    public function __construct(TokenRepository $token)
    {
        parent::__construct();

        $this->token = $token;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$tokens = $this->token->all();

        return view('apigpswox::admin.tokens.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('apigpswox::admin.tokens.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTokenRequest $request
     * @return Response
     */
    public function store(CreateTokenRequest $request)
    {
        $this->token->create($request->all());

        return redirect()->route('admin.apigpswox.token.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('apigpswox::tokens.title.tokens')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Token $token
     * @return Response
     */
    public function edit(Token $token)
    {
        return view('apigpswox::admin.tokens.edit', compact('token'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Token $token
     * @param  UpdateTokenRequest $request
     * @return Response
     */
    public function update(Token $token, UpdateTokenRequest $request)
    {
        $this->token->update($token, $request->all());

        return redirect()->route('admin.apigpswox.token.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('apigpswox::tokens.title.tokens')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Token $token
     * @return Response
     */
    public function destroy(Token $token)
    {
        $this->token->destroy($token);

        return redirect()->route('admin.apigpswox.token.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('apigpswox::tokens.title.tokens')]));
    }
}
