<?php

namespace App\Http\Controllers;

use App\Services\BadDomainService;
use Illuminate\Http\Request;

class BadDomainController extends Controller
{
    private $badDomainService;

    public function __construct(BadDomainService $badDomainService)
    {
        $this->badDomainService = $badDomainService;
    }

    public function index() {
        $domains = $this->badDomainService->getAll();

        return view('domains.index', compact('domains'));
    }

    public function create()
    {
        return view('domains.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:bad_domains|max:255',
        ]);

        $this->badDomainService->add($request->name);

        return redirect()->route('domains.index');
    }

    public function edit($id)
    {
        $domain = $this->badDomainService->get($id);

        return view('domains.edit', compact('domain'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //'name' => 'required|max:255|unique:bad_domains,name,id,' . $id,
            'name' => 'required|max:255|unique:bad_domains,name,' . $id,
        ]);

        $this->badDomainService->update($id, $request->name);

        return redirect()->route('domains.index');
    }

    public function destroy($id)
    {
        $this->badDomainService->delete($id);

        return redirect()->route('domains.index');
    }
}