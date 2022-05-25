<?php

namespace App\Services;

use phpQuery;

class ParserService 
{

    /**
     * Здесь можно добавить конструктор для урла и селектора *class, тогда в контроллере можно будет
     * кидать кастомную ссылку и название класса для парсинга
     */

    public $url = 'https://www.rbc.ru/';

    public function parser() {
        $html = $this->setCURL($this->url);

        phpQuery::newDocument($html);
        $links = pq(".js-news-feed-list")->find("a");

        foreach($links as $link){
            $link = pq($link);

            //костыль чтобы убрать не новость, как вариант можно убирать регуляркой, но, что-то сомнительно...
            if (trim($link->text()) == 'www.adv.rbc.ru') {
                continue;
            }
            $news[] = [
                "text" => trim($link->text()),
                "url"  => $link->attr("href")
            ];

            /**
             * тут можно добавить валидацию и сохранение в БД типа:
             * 
             * News::create([
             * 'text' => $news['text'],
             * 'url' => $news['url']
             * ]);
             */
        }



        phpQuery::unloadDocuments();
        return $news;
    }

    public function setCURL($url) {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_ENCODING, "" );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
        curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
        $content = curl_exec( $ch );
        curl_close ( $ch );

        return $content;
    }
}