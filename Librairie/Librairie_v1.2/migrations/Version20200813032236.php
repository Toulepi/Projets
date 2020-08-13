<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200813032236 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE LigneCommande (cmd_id INT NOT NULL, exemplaire_id INT NOT NULL,quantite INT NOT NULL , pourcentRemise FLOAT, INDEX IDX_CF33509A734413DD (cmd_id), INDEX IDX_CF33509A5843AA21 (exemplaire_id), PRIMARY KEY(cmd_id, exemplaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE LigneCommande ADD CONSTRAINT FK_CF33509A734413DD FOREIGN KEY (cmd_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE LigneCommande ADD CONSTRAINT FK_CF33509A5843AA21 FOREIGN KEY (exemplaire_id) REFERENCES exemplaire (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE LigneCommande');
    }
}
