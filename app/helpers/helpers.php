<?php

if (!function_exists('sendResponse')) {
    /**
     * Send success response for ajax request
     *
     * @param Array $result
     * @param String $message
     * @param Integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    function sendResponse(string $message, array $result=[], $code = 200)
    {
        // $result = encryptable($result);
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, $code)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
    }
}

if (!function_exists('sendError')) {
    /**
     * Send error response for ajax request
     *
     * @param String $error
     * @param Array $data
     * @param Integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    function sendError(string $error, $data = [], $code = 200)
    {

        // if(!isJson($data)){
        //     $errorMessages = json_encode($errorMessages);
        // }

        $response = [
            'success' => false,
            'data' => $data,
            'message' => $error,
        ];

        // if (!empty($errorMessages)) {
        //     $response['message'] .=  "\n Messages : \n";
        //     $response['message'] .=  $errorMessages;
        // }

        return response()->json($response, $code)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
    }
}

if (!function_exists('isJson')) {
    /**
     * Check if file name is json
     *
     * @param String $string
     * @return Boolean
     */
    function isJson(string $string){
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }
}


/**
 * Remove accents from String
 */
if(!function_exists('removeAccents')){
    function removeAccents( $text) {
        $from = explode(" ",""
            ." À Á Â Ã Ä Å Ç È É Ê Ë Ì Í Î Ï Ñ Ò Ó Ô Õ Ö Ø Ù Ú Û Ü Ý à á â"
            ." ã ä å ç è é ê ë ì í î ï ñ ò ó ô õ ö ø ù ú û ü ý ÿ Ā ā Ă ă Ą"
            ." ą Ć ć Ĉ ĉ Ċ ċ Č č Ď ď Đ đ Ē ē Ĕ ĕ Ė ė Ę ę Ě ě Ĝ ĝ Ğ ğ Ġ ġ Ģ"
            ." ģ Ĥ ĥ Ħ ħ Ĩ ĩ Ī ī Ĭ ĭ Į į İ ı Ĵ ĵ Ķ ķ Ĺ ĺ Ļ ļ Ľ ľ Ŀ ŀ Ł ł Ń"
            ." ń Ņ ņ Ň ň ŉ Ō ō Ŏ ŏ Ő ő Ŕ ŕ Ŗ ŗ Ř ř Ś ś Ŝ ŝ Ş ş Š š Ţ ţ Ť ť"
            ." Ŧ ŧ Ũ ũ Ū ū Ŭ ŭ Ů ů Ű ű Ų ų Ŵ ŵ Ŷ ŷ Ÿ Ź ź Ż ż Ž ž ƀ Ɓ Ƃ ƃ Ƈ"
            ." ƈ Ɗ Ƌ ƌ Ƒ ƒ Ɠ Ɨ Ƙ ƙ ƚ Ɲ ƞ Ɵ Ơ ơ Ƥ ƥ ƫ Ƭ ƭ Ʈ Ư ư Ʋ Ƴ ƴ Ƶ ƶ ǅ"
            ." ǈ ǋ Ǎ ǎ Ǐ ǐ Ǒ ǒ Ǔ ǔ Ǖ ǖ Ǘ ǘ Ǚ ǚ Ǜ ǜ Ǟ ǟ Ǡ ǡ Ǥ ǥ Ǧ ǧ Ǩ ǩ Ǫ ǫ"
            ." Ǭ ǭ ǰ ǲ Ǵ ǵ Ǹ ǹ Ǻ ǻ Ǿ ǿ Ȁ ȁ Ȃ ȃ Ȅ ȅ Ȇ ȇ Ȉ ȉ Ȋ ȋ Ȍ ȍ Ȏ ȏ Ȑ ȑ"
            ." Ȓ ȓ Ȕ ȕ Ȗ ȗ Ș ș Ț ț Ȟ ȟ Ƞ ȡ Ȥ ȥ Ȧ ȧ Ȩ ȩ Ȫ ȫ Ȭ ȭ Ȯ ȯ Ȱ ȱ Ȳ ȳ"
            ." ȴ ȵ ȶ ȷ Ⱥ Ȼ ȼ Ƚ Ⱦ ȿ ɀ Ƀ Ʉ Ɇ ɇ Ɉ ɉ ɋ Ɍ ɍ Ɏ ɏ ɓ ɕ ɖ ɗ ɟ ɠ ɦ ɨ"
            ." ɫ ɬ ɭ ɱ ɲ ɳ ɵ ɼ ɽ ɾ ʂ ʄ ʈ ʉ ʋ ʐ ʑ ʝ ʠ ͣ ͤ ͥ ͦ ͧ ͨ ͩ ͪ ͫ ͬ ͭ"
            ." ͮ ͯ ᵢ ᵣ ᵤ ᵥ ᵬ ᵭ ᵮ ᵯ ᵰ ᵱ ᵲ ᵳ ᵴ ᵵ ᵶ ᵻ ᵽ ᵾ ᶀ ᶁ ᶂ ᶃ ᶄ ᶅ ᶆ ᶇ ᶈ ᶉ"
            ." ᶊ ᶌ ᶍ ᶎ ᶏ ᶑ ᶒ ᶖ ᶙ ᷊ ᷗ ᷚ ᷜ ᷝ ᷠ ᷣ ᷤ ᷦ Ḁ ḁ Ḃ ḃ Ḅ ḅ Ḇ ḇ Ḉ ḉ Ḋ ḋ"
            ." Ḍ ḍ Ḏ ḏ Ḑ ḑ Ḓ ḓ Ḕ ḕ Ḗ ḗ Ḙ ḙ Ḛ ḛ Ḝ ḝ Ḟ ḟ Ḡ ḡ Ḣ ḣ Ḥ ḥ Ḧ ḧ Ḩ ḩ"
            ." Ḫ ḫ Ḭ ḭ Ḯ ḯ Ḱ ḱ Ḳ ḳ Ḵ ḵ Ḷ ḷ Ḹ ḹ Ḻ ḻ Ḽ ḽ Ḿ ḿ Ṁ ṁ Ṃ ṃ Ṅ ṅ Ṇ ṇ"
            ." Ṉ ṉ Ṋ ṋ Ṍ ṍ Ṏ ṏ Ṑ ṑ Ṓ ṓ Ṕ ṕ Ṗ ṗ Ṙ ṙ Ṛ ṛ Ṝ ṝ Ṟ ṟ Ṡ ṡ Ṣ ṣ Ṥ ṥ"
            ." Ṧ ṧ Ṩ ṩ Ṫ ṫ Ṭ ṭ Ṯ ṯ Ṱ ṱ Ṳ ṳ Ṵ ṵ Ṷ ṷ Ṹ ṹ Ṻ ṻ Ṽ ṽ Ṿ ṿ Ẁ ẁ Ẃ ẃ"
            ." Ẅ ẅ Ẇ ẇ Ẉ ẉ Ẋ ẋ Ẍ ẍ Ẏ ẏ Ẑ ẑ Ẓ ẓ Ẕ ẕ ẖ ẗ ẘ ẙ ẚ Ạ ạ Ả ả Ấ ấ Ầ"
            ." ầ Ẩ ẩ Ẫ ẫ Ậ ậ Ắ ắ Ằ ằ Ẳ ẳ Ẵ ẵ Ặ ặ Ẹ ẹ Ẻ ẻ Ẽ ẽ Ế ế Ề ề Ể ể Ễ"
            ." ễ Ệ ệ Ỉ ỉ Ị ị Ọ ọ Ỏ ỏ Ố ố Ồ ồ Ổ ổ Ỗ ỗ Ộ ộ Ớ ớ Ờ ờ Ở ở Ỡ ỡ Ợ"
            ." ợ Ụ ụ Ủ ủ Ứ ứ Ừ ừ Ử ử Ữ ữ Ự ự Ỳ ỳ Ỵ ỵ Ỷ ỷ Ỹ ỹ Ỿ ỿ ⁱ ⁿ ₐ ₑ ₒ"
            ." ₓ ⒜ ⒝ ⒞ ⒟ ⒠ ⒡ ⒢ ⒣ ⒤ ⒥ ⒦ ⒧ ⒨ ⒩ ⒪ ⒫ ⒬ ⒭ ⒮ ⒯ ⒰ ⒱ ⒲ ⒳ ⒴ ⒵ Ⓐ Ⓑ Ⓒ"
            ." Ⓓ Ⓔ Ⓕ Ⓖ Ⓗ Ⓘ Ⓙ Ⓚ Ⓛ Ⓜ Ⓝ Ⓞ Ⓟ Ⓠ Ⓡ Ⓢ Ⓣ Ⓤ Ⓥ Ⓦ Ⓧ Ⓨ Ⓩ ⓐ ⓑ ⓒ ⓓ ⓔ ⓕ ⓖ"
            ." ⓗ ⓘ ⓙ ⓚ ⓛ ⓜ ⓝ ⓞ ⓟ ⓠ ⓡ ⓢ ⓣ ⓤ ⓥ ⓦ ⓧ ⓨ ⓩ Ⱡ ⱡ Ɫ Ᵽ Ɽ ⱥ ⱦ Ⱨ ⱨ Ⱪ ⱪ"
            ." Ⱬ ⱬ Ɱ ⱱ Ⱳ ⱳ ⱴ ⱸ ⱺ ⱼ Ꝁ ꝁ Ꝃ ꝃ Ꝅ ꝅ Ꝉ ꝉ Ꝋ ꝋ Ꝍ ꝍ Ꝑ ꝑ Ꝓ ꝓ Ꝕ ꝕ Ꝗ ꝗ"
            ." Ꝙ ꝙ Ꝛ ꝛ Ꝟ ꝟ Ａ Ｂ Ｃ Ｄ Ｅ Ｆ Ｇ Ｈ Ｉ Ｊ Ｋ Ｌ Ｍ Ｎ Ｏ Ｐ Ｑ Ｒ Ｓ Ｔ Ｕ Ｖ Ｗ Ｘ"
            ." Ｙ Ｚ ａ ｂ ｃ ｄ ｅ ｆ ｇ ｈ ｉ ｊ ｋ ｌ ｍ ｎ ｏ ｐ ｑ ｒ ｓ ｔ ｕ ｖ ｗ ｘ ｙ ｚ");
        $to = explode(" ",""
            ." A A A A A A C E E E E I I I I N O O O O O O U U U U Y a a a"
            ." a a a c e e e e i i i i n o o o o o o u u u u y y A a A a A"
            ." a C c C c C c C c D d D d E e E e E e E e E e G g G g G g G"
            ." g H h H h I i I i I i I i I i J j K k L l L l L l L l L l N"
            ." n N n N n n O o O o O o R r R r R r S s S s S s S s T t T t"
            ." T t U u U u U u U u U u U u W w Y y Y Z z Z z Z z b B B b C"
            ." c D D d F f G I K k l N n O O o P p t T t T U u V Y y Z z D"
            ." L N A a I i O o U u U u U u U u U u A a A a G g G g K k O o"
            ." O o j D G g N n A a O o A a A a E e E e I i I i O o O o R r"
            ." R r U u U u S s T t H h N d Z z A a E e O o O o O o O o Y y"
            ." l n t j A C c L T s z B U E e J j q R r Y y b c d d j g h i"
            ." l l l m n n o r r r s j t u v z z j q a e i o u c d h m r t"
            ." v x i r u v b d f m n p r r s t z i p u b d f g k l m n p r"
            ." s v x z a d e i u r c g k l n r s z A a B b B b B b C c D d"
            ." D d D d D d D d E e E e E e E e E e F f G g H h H h H h H h"
            ." H h I i I i K k K k K k L l L l L l L l M m M m M m N n N n"
            ." N n N n O o O o O o O o P p P p R r R r R r R r S s S s S s"
            ." S s S s T t T t T t T t U u U u U u U u U u V v V v W w W w"
            ." W w W w W w X x X x Y y Z z Z z Z z h t w y a A a A a A a A"
            ." a A a A a A a A a A a A a A a A a E e E e E e E e E e E e E"
            ." e E e I i I i O o O o O o O o O o O o O o O o O o O o O o O"
            ." o U u U u U u U u U u U u U u Y y Y y Y y Y y Y y i n a e o"
            ." x a b c d e f g h i j k l m n o p q r s t u v w x y z A B C"
            ." D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g"
            ." h i j k l m n o p q r s t u v w x y z L l L P R a t H h K k"
            ." Z z M v W w v e o j K k K k K k L l O o O o P p P p P p Q q"
            ." Q q R r V v A B C D E F G H I J K L M N O P Q R S T U V W X"
            ." Y Z a b c d e f g h i j k l m n o p q r s t u v w x y z");
        return str_replace( $from, $to, $text);
    }
}
