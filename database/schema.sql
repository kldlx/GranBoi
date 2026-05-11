CREATE TABLE animal_peso_historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    animal_id INT NOT NULL,
    peso DECIMAL(10,2) NOT NULL,
    data_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (animal_id) REFERENCES animal(id)
);