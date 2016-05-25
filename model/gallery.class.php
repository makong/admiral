<?php

class Gallery extends Model {
    
    public    $tags_count = 5;
    protected $api_key    = 'ab0fb48379edc5af405756212de62df9';
        
    public function get_flickr_images($tag = ''){
        $data = array();
        $params = array(
            'api_key'	=> $this->api_key,
            'method'	=> 'flickr.tags.getClusterPhotos',
            'tag'       => $tag,
            'format'	=> 'php_serial',
        );

        $encoded_params = array();
        foreach ($params as $k => $v){
            $encoded_params[] = urlencode($k).'='.urlencode($v);
        }
        
        if($out = unserialize($this->curl_query('https://api.flickr.com/services/rest/?', $encoded_params))){
            if('ok' == $out['stat'] && $out['photos']){
                foreach($out['photos']['photo'] as $k => $ph){
                    $parts = array($ph['farm'], $ph['server'], $ph['id']);
                    $data[$k] = array(
                        'title' => $ph['title'],
                        'url'   => 'http://c2.staticflickr.com/'. implode('/', $parts) .'_'. $ph['secret'] .'_c.jpg'
                    );
                }
            }
        }
        
        return $data;
    }
    
    public function get_flickr_tags(){
        $data = array();
        
        if(file_exists(__SITE_PATH . '/includes/simple_html_dom.php'))
            include __SITE_PATH . '/includes/simple_html_dom.php';
        
        if($out = $this->curl_query('https://www.flickr.com/photos/tags')){
            $dom = new simple_html_dom();
            $html = $dom->load($out);
            
            if($find = $html->find('div.tag')){
                $i = 0;
                foreach($find as $f){
                    if($f->innertext && $i < $this->tags_count){
                        $data[$f->innertext] = $f->innertext;
                        $i ++;
                    }else{
                        break;
                    }
                }
            }
        }
        return $data;
    }
        
    public function curl_query($base, $postdata = array()){
       
        if($curl = curl_init()){
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_URL, "$base");
            curl_setopt($curl, CURLOPT_REFERER, "$base");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($curl, CURLOPT_HTTPHEADER, array('Expect:'));
            if($postdata){
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_POSTFIELDS, implode('&', $postdata));
            }
            $data = curl_exec($curl);
            curl_close($curl);
        }
        
        return $data;
    }
}