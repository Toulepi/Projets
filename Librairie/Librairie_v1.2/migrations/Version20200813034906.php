<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200813034906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livresAuteur (auteur_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_AEA9206B60BB6FE6 (auteur_id), INDEX IDX_AEA9206B37D925CB (livre_id), PRIMARY KEY(auteur_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livresAuteur ADD CONSTRAINT FK_AEA9206B60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id)');
        $this->addSql('ALTER TABLE livresAuteur ADD CONSTRAINT FK_AEA9206B37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE lignecommande DROP quantite, DROP pourcentRemise');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE livresAuteur');
        $this->addSql('ALTER TABLE LigneCommande ADD quantite INT NOT NULL, ADD pourcentRemise DOUBLE PRECISION DEFAULT NULL');
    }
}
