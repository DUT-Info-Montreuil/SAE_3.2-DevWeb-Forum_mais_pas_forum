<?php
Class Jeux{
private int $id_jeux;
private string $nom_jeux;
private string $configuration_minimal;
private string $configuration_requise;
private string $description_jeux;
private string $logo;

public function __construct(int $id_jeux , string $nom_jeux ,  string $configuration_minimal , string $configuration_requise , string $description_jeux ,string $logo){
    $this->id_jeux = $id_jeux;
    $this->nom_jeux = $nom_jeux;
    $this->configuration_minimal = $configuration_minimal;
    $this->configuration_requise = $configuration_requise;
    $this->description_jeux = $description_jeux;
    $this->logo = $logo;
}

public function getId(): int{
    return $this->id_jeux;
}

public function getNom_jeux(): string{
    return $this->nom_jeux;
}

public function getDescription(): string{
    return $this->description_jeux;
}
public function getConfig_minimal(): string{
    return $this->configuration_minimal;
}
public function getConfig_requise(): string{
    return $this->configuration_requise;
}

public static function fromId(int $id_jeux , string $nom_jeux , string $configuration_minimal , string $configuration_requise ,  string $description_jeux , string $logo){
    return new self( $id_jeux ,  $nom_jeux ,    $configuration_minimal ,  $configuration_requise , $description_jeux , $logo);
}

public static function fromArray(array $data): self{
    return new self($data["id_jeux"] , $data["nom_jeux"] ,  $data["configuration_minimal"] , $data["configuration_requise"] , $data["description_jeux"] ,$data["logo"]);
}

public function getLogo(): string{
    return $this->logo;
}




}
?>