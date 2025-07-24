<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Das :attribute Feld muss akzeptiert werden.',
    'accepted_if' => 'Das :attribute Feld muss akzeptiert werden, wenn :other :value ist.',
    'active_url' => 'Das :attribute Feld muss eine gültige URL sein.',
    'after' => 'Das :attribute Feld muss ein Datum nach :date sein.',
    'after_or_equal' => 'Das :attribute Feld muss ein Datum nach oder gleich :date sein.',
    'alpha' => 'Das :attribute Feld muss nur Buchstaben enthalten.',
    'alpha_dash' => 'Das :attribute Feld muss nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num' => 'Das :attribute Feld muss nur Buchstaben und Zahlen enthalten.',
    'any_of' => 'Das :attribute Feld ist ungültig.',
    'array' => 'Das :attribute Feld muss ein Array sein.',
    'ascii' => 'Das :attribute Feld muss nur alphanumerische Zeichen und Symbole enthalten.',
    'before' => 'Das :attribute Feld muss ein Datum vor :date sein.',
    'before_or_equal' => 'Das :attribute Feld muss ein Datum vor oder gleich :date sein.',
    'between' => [
        'array' => 'Das :attribute Feld muss zwischen :min und :max Elemente enthalten.',
        'file' => 'Das :attribute Feld muss zwischen :min und :max Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss zwischen :min und :max sein.',
        'string' => 'Das :attribute Feld muss zwischen :min und :max Zeichen sein.',
    ],
    'boolean' => 'Das :attribute Feld muss true oder false sein.',
    'can' => 'Das :attribute Feld enthält einen unerlaubten Wert.',
    'confirmed' => 'Die Bestätigung des :attribute Feldes stimmt nicht überein.',
    'contains' => 'Das :attribute Feld fehlt ein erforderlicher Wert.',
    'current_password' => 'Das Passwort ist falsch.',
    'date' => 'Das :attribute Feld muss ein gültiges Datum sein.',
    'date_equals' => 'Das :attribute Feld muss ein Datum gleich :date sein.',
    'date_format' => 'Das :attribute Feld muss dem Format :format entsprechen.',
    'decimal' => 'Das :attribute Feld muss :decimal Dezimalstellen haben.',
    'declined' => 'Das :attribute Feld muss abgelehnt werden.',
    'declined_if' => 'Das :attribute Feld muss abgelehnt werden, wenn :other :value ist.',
    'different' => 'Das :attribute Feld und :other müssen unterschiedlich sein.',
    'digits' => 'Das :attribute Feld muss :digits Ziffern haben.',
    'digits_between' => 'Das :attribute Feld muss zwischen :min und :max Ziffern sein.',
    'dimensions' => 'Das :attribute Feld hat ungültige Bildgrößen.',
    'distinct' => 'Das :attribute Feld hat einen doppelten Wert.',
    'doesnt_end_with' => 'Das :attribute Feld muss nicht mit einem der folgenden Werte enden: :values.',
    'doesnt_start_with' => 'Das :attribute Feld muss nicht mit einem der folgenden Werte beginnen: :values.',
    'email' => 'Das :attribute Feld muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => 'Das :attribute Feld muss mit einem der folgenden Werte enden: :values.',
    'enum' => 'Das ausgewählte :attribute ist ungültig.',
    'exists' => 'Das ausgewählte :attribute ist ungültig.',
    'extensions' => 'Das :attribute Feld muss eine der folgenden Erweiterungen haben: :values.',
    'file' => 'Das :attribute Feld muss eine Datei sein.',
    'filled' => 'Das :attribute Feld muss einen Wert haben.',
    'gt' => [
        'array' => 'Das :attribute Feld muss mehr als :value Elemente haben.',
        'file' => 'Das :attribute Feld muss größer als :value Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss größer als :value sein.',
        'string' => 'Das :attribute Feld muss größer als :value Zeichen sein.',
    ],
    'gte' => [
        'array' => 'Das :attribute Feld muss :value Elemente oder mehr haben.',
        'file' => 'Das :attribute Feld muss größer oder gleich :value Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss größer oder gleich :value sein.',
        'string' => 'Das :attribute Feld muss größer oder gleich :value Zeichen sein.',
    ],
    'hex_color' => 'Das :attribute Feld muss eine gültige hexadezimale Farbe sein.',
    'image' => 'Das :attribute Feld muss ein Bild sein.',
    'in' => 'Das ausgewählte :attribute ist ungültig.',
    'in_array' => 'Das :attribute Feld muss in :other existieren.',
    'in_array_keys' => 'Das :attribute Feld muss mindestens einen der folgenden Schlüssel enthalten: :values.',
    'integer' => 'Das :attribute Feld muss eine Ganzzahl sein.',
    'ip' => 'Das :attribute Feld muss eine gültige IP-Adresse sein.',
    'ipv4' => 'Das :attribute Feld muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'Das :attribute Feld muss eine gültige IPv6-Adresse sein.',
    'json' => 'Das :attribute Feld muss eine gültige JSON-Zeichenfolge sein.',
    'list' => 'Das :attribute Feld muss eine Liste sein.',
    'lowercase' => 'Das :attribute Feld muss in Kleinbuchstaben sein.',
    'lt' => [
        'array' => 'Das :attribute Feld muss weniger als :value Elemente haben.',
        'file' => 'Das :attribute Feld muss weniger als :value Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss weniger als :value sein.',
        'string' => 'Das :attribute Feld muss weniger als :value Zeichen sein.',
    ],
    'lte' => [
        'array' => 'Das :attribute Feld muss weniger als oder gleich :value Elemente haben.',
        'file' => 'Das :attribute Feld muss weniger als oder gleich :value Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss weniger als oder gleich :value sein.',
        'string' => 'Das :attribute Feld muss weniger als oder gleich :value Zeichen sein.',
    ],
    'mac_address' => 'Das :attribute Feld muss eine gültige MAC-Adresse sein.',
    'max' => [
        'array' => 'Das :attribute Feld muss weniger als oder gleich :max Elemente haben.',
        'file' => 'Das :attribute Feld muss weniger als oder gleich :max Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss weniger als oder gleich :max sein.',
        'string' => 'Das :attribute Feld muss weniger als oder gleich :max Zeichen sein.',
    ],
    'max_digits' => 'Das :attribute Feld muss weniger als oder gleich :max Ziffern haben.',
    'mimes' => 'Das :attribute Feld muss eine Datei des Typs :values sein.',
    'mimetypes' => 'Das :attribute Feld muss eine Datei des Typs :values sein.',
    'min' => [
        'array' => 'Das :attribute Feld muss mindestens :min Elemente haben.',
        'file' => 'Das :attribute Feld muss mindestens :min Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss mindestens :min sein.',
        'string' => 'Das :attribute Feld muss mindestens :min Zeichen sein.',
    ],
    'min_digits' => 'Das :attribute Feld muss mindestens :min Ziffern haben.',
    'missing' => 'Das :attribute Feld muss fehlen.',
    'missing_if' => 'Das :attribute Feld muss fehlen, wenn :other :value ist.',
    'missing_unless' => 'Das :attribute Feld muss fehlen, wenn :other :value ist.',
    'missing_with' => 'Das :attribute Feld muss fehlen, wenn :values vorhanden ist.',
    'missing_with_all' => 'Das :attribute Feld muss fehlen, wenn :values vorhanden sind.',
    'multiple_of' => 'Das :attribute Feld muss ein Vielfaches von :value sein.',
    'not_in' => 'Das ausgewählte :attribute ist ungültig.',
    'not_regex' => 'Das :attribute Feld hat ein ungültiges Format.',
    'numeric' => 'Das :attribute Feld muss eine Zahl sein.',
    'password' => [
        'letters' => 'Das :attribute Feld muss mindestens einen Buchstaben enthalten.',
        'mixed' => 'Das :attribute Feld muss mindestens einen Großbuchstaben und einen Kleinbuchstaben enthalten.',
        'numbers' => 'Das :attribute Feld muss mindestens eine Zahl enthalten.',
        'symbols' => 'Das :attribute Feld muss mindestens ein Symbol enthalten.',
        'uncompromised' => 'Das :attribute hat in einem Datenleck erschienen. Bitte wählen Sie ein anderes :attribute.',
    ],
    'present' => 'Das :attribute Feld muss vorhanden sein.',
    'present_if' => 'Das :attribute Feld muss vorhanden sein, wenn :other :value ist.',
    'present_unless' => 'Das :attribute Feld muss vorhanden sein, wenn :other :value ist.',
    'present_with_all' => 'Das :attribute Feld muss vorhanden sein, wenn :values vorhanden sind.',
    'prohibited' => 'Das :attribute Feld ist unzulässig.',
    'prohibited_if' => 'Das :attribute Feld ist unzulässig, wenn :other :value ist.',
    'prohibited_if_accepted' => 'Das :attribute Feld ist unzulässig, wenn :other akzeptiert ist.',
    'prohibited_if_declined' => 'Das :attribute Feld ist unzulässig, wenn :other abgelehnt ist.',
    'prohibited_unless' => 'Das :attribute Feld ist unzulässig, wenn :other nicht in :values ist.',
    'prohibits' => 'Das :attribute Feld untersagt :other, es muss vorhanden sein.',
    'regex' => 'Das :attribute Feld hat ein ungültiges Format.',
    'required' => 'Das :attribute Feld ist erforderlich.',
    'required_array_keys' => 'Das :attribute Feld muss Einträge für: :values enthalten.',
    'required_if' => 'Das :attribute Feld ist erforderlich, wenn :other :value ist.',
    'required_if_accepted' => 'Das :attribute Feld ist erforderlich, wenn :other akzeptiert ist.',
    'required_if_declined' => 'Das :attribute Feld ist erforderlich, wenn :other abgelehnt ist.',
    'required_unless' => 'Das :attribute Feld ist erforderlich, wenn :other nicht in :values ist.',
    'required_with' => 'Das :attribute Feld ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all' => 'Das :attribute Feld ist erforderlich, wenn :values vorhanden sind.',
    'required_without' => 'Das :attribute Feld ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das :attribute Feld ist erforderlich, wenn keines der :values vorhanden ist.',
    'same' => 'Das :attribute Feld muss mit :other übereinstimmen.',
    'size' => [
        'array' => 'Das :attribute Feld muss :size Elemente enthalten.',
        'file' => 'Das :attribute Feld muss :size Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss :size sein.',
        'string' => 'Das :attribute Feld muss :size Zeichen sein.',
    ],
    'starts_with' => 'Das :attribute Feld muss mit einem der folgenden Werte beginnen: :values.',
    'string' => 'Das :attribute Feld muss eine Zeichenfolge sein.',
    'timezone' => 'Das :attribute Feld muss eine gültige Zeitzone sein.',
    'unique' => 'Das :attribute hat bereits genommen.',
    'uploaded' => 'Das :attribute Feld konnte nicht hochgeladen werden.',
    'uppercase' => 'Das :attribute Feld muss in Großbuchstaben sein.',
    'url' => 'Das :attribute Feld muss eine gültige URL sein.',
    'ulid' => 'Das :attribute Feld muss eine gültige ULID sein.',
    'uuid' => 'Das :attribute Feld muss eine gültige UUID sein.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
