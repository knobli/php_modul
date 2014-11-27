<?php
class GermanToEnglishModification extends ModificationDecorator {
	
    public function __construct(Component $component) {
        parent::__construct($component);    
    }

    public function getValue() {
        switch (parent::getValue()) {
            case 'Kuerzel':       return 'Shortname';
            case 'Kanton':        return 'Canton';
            case 'Standesstimme': return 'Voices';
            case 'Beitritt':      return 'Joined';
            case 'Hauptort':      return 'Capital';
            case 'Einwohner 1':   return 'Population';
            case 'Auslaender 2':  return 'Foreignes';
            case 'Flaeche 3':     return 'Area';
            case 'Dichte 4':      return 'Density';
            case 'Gemeinden 6':   return 'Communs';
            case 'Amtssprache':   return 'Language';
            default:              return parent::get_value();
        }
    }
}
?>