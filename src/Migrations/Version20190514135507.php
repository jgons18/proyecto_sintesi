<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190514135507 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE detail ADD carrier_id INT NOT NULL, ADD paymentmethod_id INT NOT NULL');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F9321DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93778E3E6F FOREIGN KEY (paymentmethod_id) REFERENCES paymentmethod (id)');
        $this->addSql('CREATE INDEX IDX_2E067F9321DFC797 ON detail (carrier_id)');
        $this->addSql('CREATE INDEX IDX_2E067F93778E3E6F ON detail (paymentmethod_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F9321DFC797');
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F93778E3E6F');
        $this->addSql('DROP INDEX IDX_2E067F9321DFC797 ON detail');
        $this->addSql('DROP INDEX IDX_2E067F93778E3E6F ON detail');
        $this->addSql('ALTER TABLE detail DROP carrier_id, DROP paymentmethod_id');
    }
}
