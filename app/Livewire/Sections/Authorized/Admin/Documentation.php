<?php

namespace App\Livewire\Sections\Authorized\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Documentation extends Component
{
    public $directory = "", $folders = [], $files = [];

    public $creatingFolder, $folderName;
    public $creatingFile, $fileName, $fileView, $fileContent;

    public function openFile($name)
    {
        $fileRoute = "documentation" . $this->directory . '/' . $name;

        if (Storage::exists($fileRoute)) {
            $this->fileContent = Storage::get($fileRoute);
            $this->fileView = $fileRoute;
        }
    }

    public function saveFileContent()
    {
        Storage::put($this->fileView, $this->fileContent);
    }

    public function addDirectory($string)
    {
        $this->directory = $this->directory . '/' . $string;
    }

    public function setDirectory($string)
    {
        if (!$string) {
            $this->directory = "";
            return;
        }

        if ($string == 'Inicio') {
            $this->directory = "";
            return;
        }

        $this->directory = $string;
    }

    public function closeFile()
    {
        $this->fileView = false;
        $this->fileContent = null;
    }

    public function backDirectory()
    {
        if ($this->fileView) {
            $this->saveFileContent();
            $this->closeFile();
        }
        // Quitar el último segmento del directorio actual
        $parts = explode('/', $this->directory);
        array_pop($parts);
        $this->directory = implode('/', $parts);
    }

    public function updatedCreatingFolder()
    {
        $this->reset(['folderName']);
    }

    public function updatedCreatingFile()
    {
        $this->reset(['fileName']);
    }

    public function createFolder()
    {
        $this->validate([
            'folderName' => 'required|min:3|max:30'
        ], [
            'folderName.required' => 'El nombre de la carpeta es requerido.',
            'folderName.min' => 'El nombre de la carpeta debe tener al menos 3 caracteres.',
            'folderName.max' => 'El nombre de la carpeta debe tener máximo 30 caracteres.'
        ]);

        Storage::makeDirectory("documentation/" . $this->directory . '/' . $this->folderName);

        $this->reset(['creatingFolder', 'folderName']);
    }

    public function createFile()
    {
        $this->validate([
            'fileName' => 'required|min:3|max:30'
        ], [
            'fileName.required' => 'El nombre del archivo es requerido.',
            'fileName.min' => 'El nombre del archivo debe tener al menos 3 caracteres.',
            'fileName.max' => 'El nombre del archivo debe tener máximo 30 caracteres.'
        ]);

        Storage::put("documentation/" . $this->directory . '/' . $this->fileName . ".md", "");

        $this->reset(['creatingFile', 'fileName']);
    }

    public function render()
    {
        $this->folders = Storage::directories("documentation/" . $this->directory);
        $this->files = Storage::files("documentation/" . $this->directory);

        return view('livewire.sections.authorized.admin.documentation');
    }
}
