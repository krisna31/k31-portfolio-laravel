<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return inertia('Notes/Index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Notes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $note = Note::create($data);

        return redirect()->route('notes.index')->with('success', "Data $note->title Berhasil Dibuat");
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return inertia('Notes/Show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return inertia('Notes/Edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());

        return redirect()->route('notes.index')->with('success', "Data $note->title Berhasil Diupdate");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index')->with('success', "Data $note->title Berhasil DIhapus");
    }
}
