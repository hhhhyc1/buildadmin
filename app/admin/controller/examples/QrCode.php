<?php

namespace app\admin\controller\examples;

use app\common\controller\Backend;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode as QR;
use Endroid\QrCode\ErrorCorrectionLevel;

class QrCode extends Backend
{
    /**
     * 生成二维码
     */
    public function create()
    {
        $params = input('post.');
        $qrCode = new QR($params['data']);
        $qrCode->setEncoding('UTF-8');

        $qrCode->setSize($params['size'] ? intval($params['size']) : 200);
        $qrCode->setMargin($params['margin'] ? intval($params['margin']) : 10);

        $qrCode->setForegroundColor($this->changeColor($params['fore_color']));
        $qrCode->setBackgroundColor($this->changeColor($params['back_color']));

        if ($params['error_level'] == 'low') {
            $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::LOW());
        } elseif ($params['error_level'] == 'medium') {
            $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::MEDIUM());
        } elseif ($params['error_level'] == 'quartile') {
            $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::QUARTILE());
        } elseif ($params['error_level'] == 'high') {
            $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
        }

        //展示标签
        if ($params['show_tag'] == 1) {

            if ($params['font'] == 0) {
                $fontPath = app()->getRootPath() . 'vendor/endroid/qr-code/assets/fonts/noto_sans.otf';
            } else {
                $fontPath = app()->getRootPath() . 'vendor/endroid/qr-code/assets/fonts/open_sans.ttf';
            }

            $label     = $params['tag'] ? $params['tag'] : 'buildAdmin';
            $labelSize = $params['tag_size'] ? intval($params['tag_size']) : 16;

            if ($params['alignment'] == 'left') {
                $labelAlignment = LabelAlignment::LEFT();
            } elseif ($params['alignment'] == 'right') {
                $labelAlignment = LabelAlignment::RIGHT();
            } else {
                $labelAlignment = LabelAlignment::CENTER();
            }

            $qrCode->setLabel($label, $labelSize, $fontPath, $labelAlignment, [
                't' => $params['t'] ? intval($params['t']) : 0,
                'r' => $params['r'] ? intval($params['r']) : 10,
                'b' => $params['b'] ? intval($params['b']) : 10,
                'l' => $params['l'] ? intval($params['l']) : 10,
            ]);
        }

        // 展示logo
        if ($params['show_logo'] == 1) {
            $qrCode->setLogoPath(app()->getRootPath() . 'web/src/assets/logo.png');
            $qrCode->setLogoSize($params['logo_size'] ? intval($params['logo_size']) : 50);
        }

        // 二维码保存路径
        $dir = app()->getRootPath() . 'public/storage/qrcode/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        $name = time() . '_qrcode.png';
        $qrCode->writeFile($dir . $name);

        $this->success('', [
            'url' => request()->domain() . '/storage/qrcode/' . $name,
        ]);
    }

    /**
     * 颜色数据格式转换
     */
    public function changeColor($str): array
    {
        $str = substr($str, 5, -1);
        $arr = explode(',', $str);
        return [
            'r' => $arr[0],
            'g' => $arr[1],
            'b' => $arr[2],
            'a' => $arr[3]
        ];
    }
}