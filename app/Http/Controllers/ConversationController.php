<?php

namespace App\Http\Controllers;

use App\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $convesations = Conversation::all();
        return view('conversations.list', compact('convesations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Conversation $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Conversation $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Conversation $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Conversation $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation) {
        //
    }

    static function save($data,$type,$subtype){
        $conversation = new Conversation();
        $conversation->type = $type;
        $conversation->subtype= $subtype;
        $conversation->data = json_encode($data);
        if($conversation->save()){
            return redirect()->back()->withErrors(['Mesnaje'=>'guardado cor exito']);
        }else{
            return redirect()->route('home');
        }
    }

    public function changeStatus($id,$status){
        $conversation = Conversation::find($id);
        $conversation->status = $status;
        if($conversation->save()){
            flash('Finalizado satisfactoriamente.')->success();
            return redirect()->back();
        }else{
            flash('El servicio no pudo ser finalizado.')->error();
            return redirect()->back();
        }
    }
}
