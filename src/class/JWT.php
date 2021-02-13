<?php

require "../exceptions/TokenInvalidException.php";
require "../utils/errors.php";

class JWT {

    private static $KID = "";
    private static $SIGN = "";
    private static $ALGORITHM = "HS256";
    private static $HASH = "sha256";

    public static function setup(string $KID, string $SIGN): void {
        /**
         * Set up the signing string to the tokens
         * 
         * @param string $KID header string to encode
         * @param string $SIGN sign payload with this string to generate an unique sign if the payload is altered
         */
        self::$KID = $KID;
        self::$SIGN = $SIGN;
    }

    public static function encode(array $payload, string $exp = "30 minutes"): string {
        /**
         * Encode a token setting the payload to what it needs to be
         * 
         * @param array $payaload must be a key=>pair array containing the payload of the token.
         *              the parameters iat, exp, iss will be replaced for the ones in need.
         * 
         * @param string $exp expiration rate of the token
         * 
         * @return string
         */

        global $ENV;

        $header = json_encode([
            "kid" => self::$KID,
            "algorithm" => self::$ALGORITHM
        ]);
        $header = base64_encode($header);

        $body = array_unique($payload);
        
        $date = date_create();

        $body["iat"] = date_format($date, "U");
        $date = date_add($date, date_interval_create_from_date_string($exp));
        $body["exp"] = date_format($date, "U");
        $body["iss"] = $ENV["DOMAIN"];
        
        $body = json_encode($body);
        $body = base64_encode($body);

        $secret = self::$SIGN;

        $sign = hash(self::$HASH, "{$header}.{$body}.{$secret}");
        $token = "{$header}.{$body}.{$sign}";

        return $token;
    }

    public static function decode(string $token): array {
        /**
         * Decodes a token and return the header, payload and sign of it
         * 
         * @param string $token token to be decoded
         * 
         * @return array
         */

        $token = explode(".", $token, 3);
        $token_header = $token[0];
        $token_body = $token[1];
        $token_sign = $token[2];

        $secret = self::$SIGN;

        $sign = hash(self::$HASH, "{$token_header}.{$token_body}.{$secret}");

        if ( $token_sign !== $sign ) {
            throw new TokenInvalidException(Error::$TOKEN_INVALID);
        }

        $token_body = base64_decode($token_body);
        $body = json_decode($token_body);

        return $body;
    }

    public static function is_expired(array $body): bool {
        /**
         * Indicate if the exp field is already passed the datetime generated
         * 
         * @param array $body content of the token
         * 
         * @return bool
         */

        $is_expired = TRUE;

        if (in_array("exp", $body) === FALSE) {
            return $is_expired;
        }

        $date = date_create();
        $date = date_format($date, "U");

        if ($date > $body["exp"]) {
            $is_expired = FALSE;
        }

        return $is_expired;
    }
}

?>