<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Plugin;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    public function index()
    {
        $page_title = 'Complemento y extensión';
        $plugins = Plugin::orderByDesc('status')->get();
        return view('admin.plugin.index', compact('page_title', 'plugins'));
    }

    public function update(Request $request, $id)
    {
        $plugin = Plugin::findOrFail($id);

        foreach ($plugin->shortcode as $key => $val) {
            $validation_rule = [$key => 'required'];
        }
        $request->validate($validation_rule);

        $shortcode = json_decode(json_encode($plugin->shortcode), true);
        foreach ($shortcode as $key => $code) {
            $shortcode[$key]['value'] = $request->$key;
        }

        $plugin->update(['shortcode' => $shortcode]);
        $notify[] = ['success', $plugin->name . ' Ha ido Actualizado'];
        return redirect()->route('admin.plugin.index')->withNotify($notify);
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $plugin = Plugin::findOrFail($request->id);
        $plugin->update(['status' => 1]);
        $notify[] = ['success', $plugin->name . ' Ha Sido Desactivado'];
        return redirect()->route('admin.plugin.index')->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $plugin = Plugin::findOrFail($request->id);
        $plugin->update(['status' => 0]);
        $notify[] = ['success', $plugin->name . ' Ha Sido Eliminado'];
        return redirect()->route('admin.plugin.index')->withNotify($notify);
    }
}
