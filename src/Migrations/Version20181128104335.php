<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181128104335 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE proverb DROP FOREIGN KEY FK_9271AE88D70E78A');
        $this->addSql('DROP INDEX UNIQ_9271AE88D70E78A ON proverb');
        $this->addSql('ALTER TABLE proverb DROP proberb_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE proverb ADD proberb_id INT NOT NULL');
        $this->addSql('ALTER TABLE proverb ADD CONSTRAINT FK_9271AE88D70E78A FOREIGN KEY (proberb_id) REFERENCES country (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9271AE88D70E78A ON proverb (proberb_id)');
    }
}
