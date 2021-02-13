<?php

class WebCard {

    public static $ALLOWED_THEMES = [
        "classic"
    ];

    public $table = "webcard";
    
    public $id = "";
    public $created_datetime = NULL;
    public $updated_datetime = NULL;
    public $is_active = FALSE;
    public $theme = "";
    public $show_share = FALSE;
    public $auto_play = FALSE;
    public $opens_new_tab = FALSE;
    public $public = FALSE;
    public $owner_id = NULL;
    public $title = "";
    public $subtitle = "";
    public $preview = "";
    public $preview_on_platform = "";

    public $error = "";

    public function __construct(){}

    public static function create(array $arguments): WebCard {
        /**
         * Using the properties of the class, it sets all the value of a new
         * self instance and saves it in the database
         * 
         * @param array $arguments
         * 
         * @return WebCard 
         */

        $webcard = new WebCard();

        foreach ($arguments as $key => $value) {
            $webcard->{$key} = $value;
        }

        $date = date_create();
        $date = intval(date_format($date, "U"));

        $webcard->created_datetime = $date;
        $webcard->updated_datetime = $date;
        
        $webcard->save();

        return $webcard;
    }

    public function save() {
        /**
         * We save the instance in a new record for the user
         */
        global $DATABASE;

        if (in_array($this->theme, self::$ALLOWED_THEMES) === FALSE) {
            throw new RequestException(ErrorMessage::$INVALID_THEMECARD);
        }

        $command = "INSERT INTO {$this->table}(
            id,
            created_datetime,
            updated_datetime,
            is_active,
            theme,
            show_share,
            auto_play,
            opens_new_tab,
            public,
            owner_id,
            title,
            subtitle,
            preview,
            preview_on_platform
        ) VALUES (
            :id,
            :created_datetime,
            :updated_datetime,
            :is_active,
            :theme,
            :show_share,
            :auto_play,
            :opens_new_tab,
            :public,
            :owner_id,
            :title,
            :subtitle,
            :preview,
            :preview_on_platform
        )";
        
        if (empty($this->id)) {
            $this->id = uniqid();
        }

        $DATABASE->query($command, [
            ":id" => $this->id,
            ":created_datetime" => $this->created_datetime,
            ":updated_datetime" => $this->updated_datetime,
            ":is_active" => $this->is_active ? 1 : 0,
            ":theme" => $this->theme,
            ":show_share" => $this->show_share ? 1 : 0,
            ":auto_play" => $this->auto_play ? 1 : 0,
            ":opens_new_tab" => $this->opens_new_tab ? 1 : 0,
            ":public" => $this->public ? 1 : 0,
            ":owner_id" => $this->owner_id,
            ":title" => $this->title,
            ":subtitle" => $this->subtitle,
            ":preview" => $this->preview,
            ":preview_on_platform" => $this->preview_on_platform ? 1 : 0
        ]);

        $DATABASE->execute();

    }
}

?>