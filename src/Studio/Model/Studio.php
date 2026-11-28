<?php

Class Studio {
    private int $id_studio;
    private string $nom_studio;
    private int $nb_abonne = 0;//car il commence sans abonner
    private string $logo_studio;
    private string $description_studio;

    public function __construct(int $id_studio ,string $nom_studio , string $description_studio,string $logo_studio ){
        $this->id_studio = $id_studio;
        $this->nom_studio = $nom_studio;
        $this->logo_studio = $logo_studio;
        $this->description_studio = $description_studio;
    }

    public function getIdStudio(): int{return $this->id_studio;}
    public function getNbAbonne(): int{return $this->nb_abonne;}
    public function getNomStudio(): string{return $this->nom_studio;}
    public function getDescriptionStudio(): string{return $this->description_studio;}
    public function getLogoStudio(): string{return $this->logo_studio;}
}