<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class EntidadController extends Controller
{
    private string $pythonPath;
    private string $scriptPath;

    public function __construct()
    {
        $this->pythonPath = env('PYTHON_PATH');
        $this->scriptPath = base_path(env('PYTHON_SCRIPT_PATH'));
    }

    public function index()
    {
        Log::info(getenv());
        return view('entidades.index');
    }

    public function extraerEntidades(Request $request)
    {
        $url = $request->input('url');

        if (!$this->validarRutaScript()) {
            Log::error("Script de Python no encontrado en la ruta: " . $this->scriptPath);
            return response()->json(['error' => 'Script no encontrado.'], 500);
        }

        $process = $this->crearProcesoPython($url);

        $process->run();

        if (!$process->isSuccessful()) {
            Log::error('Error en el script de Python: ' . $process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();
        Log::info('Salida del script de Python: ' . $output);
        return response()->json(json_decode($output));
    }

    private function validarRutaScript(): bool
    {
        return file_exists($this->scriptPath);
    }

    private function crearProcesoPython(string $url): Process
    {
        $env = array_merge(getenv(), [
            'PYTHONIOENCODING' => 'UTF-8',
            'PATH' => getenv('PATH') . ';' . dirname($this->pythonPath)
        ]);

        return new Process([$this->pythonPath, $this->scriptPath, $url], null, $env);
    }
}
