<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.08.17
 * Time: 18:32
 */

namespace rollun\dataFormat\Helpers;

use Zend\View\Helper\AbstractHelper;

class ExportImport extends AbstractHelper
{
    public function __invoke($dataStoreName, $converterName, $isExport = true, $isImport = false)
    {
        $data = "<div>";
        $data .= $isExport ? $this->getExport($dataStoreName, $converterName) : "";
        $data .= $isImport ? $this->getImport($dataStoreName, $converterName) : "";
        $data .= "</div>";
    }

    protected function getExport($dataStoreName, $converterName)
    {
        $url = $this->getView()->url('DataStoreExporter', ["dataStore" => $dataStoreName, "converter" => $converterName]);
        $html = "<a href='$url'>Download $dataStoreName</a>";
        return $html;
    }

    protected function getImport($dataStoreName, $converterName)
    {
        $url = $this->getView()->url('DataStoreImporter', ["dataStore" => $dataStoreName, "converter" => $converterName]);
        $html =
            <<<IMPORT_FORM
<div class="row">
    <div class="col-md-offset-4 col-md-4">
        <h2>Загрузить таблицу $dataStoreName</h2>
        <?/*http://192.168.1.103:8080/report_upload */?>
        <form enctype="multipart/form-data" action="$url" method="POST">
            Отправить этот файл: <input name="userfile" type="file"/>
            <input type="submit" value="Загрузить файл"/>
        </form>
    </div>
</div>
IMPORT_FORM;
        return $html;
    }
}
