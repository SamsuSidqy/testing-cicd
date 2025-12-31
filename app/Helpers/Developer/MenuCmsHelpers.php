<?php

namespace App\Helpers\Developer;

use Illuminate\Support\Facades\Auth;
use Request;

class MenuCmsHelpers
{
    /**
     * Membuat controller baru & overwrite bila sudah ada.
     */
    public static function CreateController($controller, $views, $method, $parent = null)
    {
        try {
            $basePath = app_path('Http/Controllers/Auth/Page/');
            $namespaceBase = "App\Http\Controllers\Auth\Page";

            // Lengkapi folder parent bila ada
            $folderPath = $basePath . ($parent ? "$parent/" : "");

            // Full path file controller
            $filePath = $folderPath . $controller . '.php';

            // Pastikan folder ada
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // Normalisasi parent
            $parentNamespace = $parent ? str_replace('/', '\\', trim($parent, '/')) : null;
            $parentView      = $parent ? str_replace('/', '.', trim($parent, '/')) : null;

            // Namespace dinamis
            $namespace = $namespaceBase . ($parentNamespace ? "\\{$parentNamespace}" : "");

            // Path view (blade)
            $viewPath = "Auth" . ($parentView ? ".{$parentView}" : "") . ".{$views}";

            // Isi file controller
            $content  = "<?php\n\n";
            $content .= "namespace $namespace;\n\n";
            $content .= "use App\Http\Controllers\Controller;\n\n";
            $content .= "use Illuminate\Http\Request;\n\n";
            $content .= "class $controller extends Controller\n{\n";
            $content .= "    public function $method(Request \$req)\n    {\n";
            $content .= "        return view('$viewPath');\n";
            $content .= "    }\n";
            $content .= "}\n";

            // SELALU OVERWRITE
            file_put_contents($filePath, $content);

            return true;

        } catch (\Exception $err) {
            return false;
        }
    }

    /**
     * Membuat file blade view & overwrite bila sudah ada.
     */
    public static function CreateBladeViews($views, $parent = null)
    {
        try {
            $basePath = resource_path('views/Auth/');

            // Tambah parent folder
            $folderPath = $basePath . ($parent ? "$parent/" : "");

            // Full path file blade
            $filePath = $folderPath . "$views.blade.php";

            // Buat folder bila belum ada
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // Isi default blade file
            $content  = "@extends('layout.dashboard')\n";
            $content .= "@section('section_dashboard')\n\n";
            $content .= "<main>\n";
            $content .= "    <div class='container-fluid'>\n";
            $content .= "        <h1>Menu Berhasil Dibuat</h1>\n";
            $content .= "    </div>\n";
            $content .= "</main>\n\n";
            $content .= "@endsection";

            // Tulis ulang (overwrite)
            file_put_contents($filePath, $content);

            return true;

        } catch (\Exception $err) {
            return false;
        }
    }
}