const mysql = require('mysql');

class DBConnection {
  constructor() {
    this.connection = mysql.createConnection({
      host: 'localhost',
      user: 'root',
      password: '',
      port: 3306,
      database: 'crud-node-app'
    });
  }


  connect() {
    return new Promise((resolve, reject) => {
      this.connection.connect((err) => {
        if (err) {
          console.error('Connection error:', err.message);
          reject(err);
        } else {
          console.log('Database connection successful');
          resolve();
        }
      });
    });
  }

  query(sql, args = []) {
    return new Promise((resolve, reject) => {
      this.connection.query(sql, args, (err, results) => {
        if (err) {
          console.error('Query error:', err.message);
          reject(err);
        } else {
          resolve(results);
        }
      });
    });
  }

  close() {
    return new Promise((resolve, reject) => {
      this.connection.end((err) => {
        if (err) {
          console.error('Error closing connection:', err.message);
          reject(err);
        } else {
          console.log('Connection closed successfully');
          resolve();
        }
      });
    });
  }
}

module.exports = DBConnection;