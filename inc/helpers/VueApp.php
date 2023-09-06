<?php

namespace theme\helpers;

use theme\core\Component;

/**
 *
 */
class VueApp extends Component {
    private string $_content;
    private array $_options;

    /**
     * @param array $conf
     */
    public function __construct( array $conf = [] ) {
        parent::__construct( $conf );

        $this->_content = sanitize_text_field( $this->empty_text ?? '' );

        $this->_options = $this->attributes ?? [];

        $this->_options['data'] = [
            'component' => sanitize_text_field( $this->name ?? null ),
            'props' => $this->props ?? [],
        ];

    }

    /**
     * @return string
     */
    public function render(): string {
        return Html::div( $this->_content, $this->_options );
    }

    /**
     * @return mixed
     */
    public function __toString() {
        return $this->render();
    }
}