<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316184449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE piezas_iphone (id INT AUTO_INCREMENT NOT NULL, modelo_id_id INT NOT NULL, pieza VARCHAR(255) NOT NULL, precio INT NOT NULL, cantidad INT NOT NULL, INDEX IDX_D15FE72C7EF8F306 (modelo_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reparaciones (id INT AUTO_INCREMENT NOT NULL, usuario_id_id INT NOT NULL, descripcion VARCHAR(255) NOT NULL, fecha DATE NOT NULL, INDEX IDX_60AF46E629AF449 (usuario_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reparaciones_piezas_iphone (reparaciones_id INT NOT NULL, piezas_iphone_id INT NOT NULL, INDEX IDX_E1EC6C8CB40DEEBB (reparaciones_id), INDEX IDX_E1EC6C8CBDFD532B (piezas_iphone_id), PRIMARY KEY(reparaciones_id, piezas_iphone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE piezas_iphone ADD CONSTRAINT FK_D15FE72C7EF8F306 FOREIGN KEY (modelo_id_id) REFERENCES modelos_iphone (id)');
        $this->addSql('ALTER TABLE reparaciones ADD CONSTRAINT FK_60AF46E629AF449 FOREIGN KEY (usuario_id_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reparaciones_piezas_iphone ADD CONSTRAINT FK_E1EC6C8CB40DEEBB FOREIGN KEY (reparaciones_id) REFERENCES reparaciones (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reparaciones_piezas_iphone ADD CONSTRAINT FK_E1EC6C8CBDFD532B FOREIGN KEY (piezas_iphone_id) REFERENCES piezas_iphone (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piezas_iphone DROP FOREIGN KEY FK_D15FE72C7EF8F306');
        $this->addSql('ALTER TABLE reparaciones DROP FOREIGN KEY FK_60AF46E629AF449');
        $this->addSql('ALTER TABLE reparaciones_piezas_iphone DROP FOREIGN KEY FK_E1EC6C8CB40DEEBB');
        $this->addSql('ALTER TABLE reparaciones_piezas_iphone DROP FOREIGN KEY FK_E1EC6C8CBDFD532B');
        $this->addSql('DROP TABLE piezas_iphone');
        $this->addSql('DROP TABLE reparaciones');
        $this->addSql('DROP TABLE reparaciones_piezas_iphone');
    }
}
