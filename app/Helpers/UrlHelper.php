<?php

namespace App\Helpers;

use App\Url;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Hashids\Hashids;

class UrlHelper
{
    public function urlGenerator()
    {
        $getUrlIdInDB = Url::orderBy('id', 'desc')->limit(1)->first();

        $hashids = new Hashids('', 6);

        if (empty($getUrlIdInDB)) {
            $shortURL = $hashids->encode(1);
        } else {
            $shortURL = $hashids->encode($getUrlIdInDB->id + 1);
        }

        return $shortURL;
    }

    public function get_title($getLongURL)
    {
        $data = @file_get_contents($getLongURL);

        if($data == true){
            $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;
        }else{
            $title = $getLongURL;
        }

        return $title;
    }

    public function qrCodeGenerator($short_url)
    {
        $qrCode = new QrCode();
        $qrCode
            ->setText(url('/', $short_url))
            ->setSize(150)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setLabel('Scan Qr Code')
            ->setLabelFontSize(12)
            ->setImageType(QrCode::IMAGE_TYPE_PNG)
        ;

        return $qrCode;
    }
}