<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Services\ClickService;
use Illuminate\Http\Request;

class ClickController extends Controller
{
    private $clickService;

    public function __construct(ClickService $clickService)
    {
        $this->clickService = $clickService;
    }

    public function index()
    {
        return view('click.index');
    }

    public function add(Request $request)
    {
        $userAgent = $request->headers->get('user_agent');
        $referer = $request->headers->get('referer');

        $status = $this->clickService->add(
            $request->ip(), $userAgent, $referer, $request->get('param1'), $request->get('param2'));

        session(['isRedirect' => $status->isRedirect()]);

        return redirect()->route('status', ['action' => $status->getAction(), 'id' => $status->getId()]);
    }

    public function get(Request $request)
    {
        $clicks = $this->clickService->search($request->all());
        $columns = Click::$columns;

        return response()->json(['clicks' => $clicks, 'columns' => $columns]);
    }

    public function destroy($id)
    {
        $result = $this->clickService->delete($id);
        $id = $result ? $id : '';

        return response()->json(['id' => $id]);
    }
}