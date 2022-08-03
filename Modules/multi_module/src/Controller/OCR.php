<?php

namespace Drupal\multi_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\ConfigFormBaseTrait;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Entity\EntityResolverManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Drupal\file\Entity\File;

class OCR extends ControllerBase
{

  public function content()
  {
    $config = \Drupal::config('multi_module.settings');
    $Route = $config->get('OCR.url');
    $Route2 = $config->get('OCR.language');
    $Route3 = $config->get('OCR.name_file');
    var_dump($Route3);
    if (!empty($Route)){
      $post = http_build_query([
        'url' => $Route,
        'language' => $Route2,
        'isOverlayRequired' => 'false',
      ]);
    }
    else{
      $entity = \Drupal::entityTypeManager()
        ->getStorage('file')
        ->loadByProperties([
          'fid' => $Route3,
        ]);
      $file = current($entity);
      $path = file_create_url($file->getFileUri());
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
      $post = http_build_query([
        'base64Image' => $base64,
        'language' => $Route2,
        'isOverlayRequired' => 'false',
      ]);
    }
    $request = \Drupal::httpClient()->post('https://api.ocr.space/parse/image', [
      'body' => $post,
      'headers' => array('apikey' => '3a3fcb148488957', 'Content-Type' => 'application/x-www-form-urlencoded')
    ]);
    $json = $request->getBody()->getContents();
    $piece1= '"ProcessingTimeInMilliseconds":"';
    $piece2= '","SearchablePDFURL"';
    $grep = preg_replace("/$piece1.*$piece2/is", '', $json);
    $Delete = ['","ErrorMessage":"","ErrorDetails":""}],"OCRExitCode":1,"IsErroredOnProcessing":false,:"Searchable PDF not generated as it was not requested."}', '{"ParsedResults":[{"TextOverlay":{"Lines":[],"HasOverlay":false,"Message":"Text overlay is not provided as it is not requested"},"TextOrientation":"0","FileParseExitCode":1,"ParsedText":"'];
    $res = str_replace($Delete, '', $grep);
    $Delete2 =['\r\n'];
    $res = str_replace($Delete2, ' ', $res);
    /**
    $post = http_build_query([
      'target' => $Route3,
      'q' => $res,
    ]);
    $request = \Drupal::httpClient()->post('https://google-translate1.p.rapidapi.com/language/translate/v2', [
      'body'=>$post,
      'headers' => array('Content-type' => 'application/x-www-form-urlencoded', 'X-RapidAPI-Host' => 'google-translate1.p.rapidapi.com', 'X-RapidAPI-Key' => 'fb332403damsh93459003ace8ccbp14abc5jsnb286b43c91ae', 'Accept-Encoding' => 'application/gzip')
    ]);
     **/
    $json = $request->getBody()->getContents();
    return array(
      '#type' => 'html_tag',
      '#tag' => 'h1',
      '#value' => $res,
      '#attributes' => [
        'class' => ['hello-world'],
      ],
    );
  }
}
