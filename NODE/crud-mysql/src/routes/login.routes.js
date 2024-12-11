const { Router } = require("express");
const DBConnection = require('../config/dbConnection');
const bcrypt = require('bcrypt');
const saltRounds = 10;
const router = Router();

router.post('/', async (req, res) => {
  const db = new DBConnection();
  try {
    await db.connect();
    const getUser = await db.query(`SELECT * FROM user WHERE user_user="${req.body.user}"`);
    if (Object.keys(getUser).length != 0) {
      const isMatch = await bcrypt.compare(req.body.password, getUser[0]['user_password']);
      if (isMatch) {
        res.json({ message: "Method Post : Successful Entry", data: 'ok', status: 200 });
      } else {
        res.json({ message: "Method Post : Password Error", data: 'error', status: 404 });
      }
    } else {
      res.json({ message: "Method Post : The user not created", data: 'error', status: 404 });
    }
  } catch (err) {
    res.json({ message: "Error Post ", data: err.message, status: 404 });
  } finally {

    await db.close();
  }
})

module.exports = router;