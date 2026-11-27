<?php

Class Studio {
    private int $id_studio;
    private string $nom_studio;
    private int $nb_abonne = 0;//car il commence sans abonner

    public function __construct(int $id_studio ,string $nom_studio){
        $this->id_studio = $id_studio;
        $this->nom_studio = $nom_studio;
    }

    public function getIdStudio(): int{return $this->id_studio;}
    public function getNbAbonne(): int{return $this->nb_abonne;}
    public function getNomStudio(): string{return $this->nom_studio;}
}