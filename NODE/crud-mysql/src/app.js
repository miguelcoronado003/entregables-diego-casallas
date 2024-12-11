const express = require("express");
const cors = require("cors");
const userRoutes = require("./routes/user.routes");
const roleRoutes = require("./routes/role.routes");
const userStatusRoutes = require("./routes/userStatus.routes");
const moduleRoutes = require("./routes/module.routes");
const roleModuleRoutes = require("./routes/roleModule.routes");
const loginRoutes = require("./routes/login.routes");


const app = express();
const port = 4000;



app.use(cors());
app.use(express.json());


app.use('/api-v1/user', userRoutes);
app.use('/api-v1/role', roleRoutes);
app.use('/api-v1/userStatus', userStatusRoutes);
app.use('/api-v1/module', moduleRoutes);
app.use('/api-v1/roleModule', roleModuleRoutes);
app.use('/api-v1/login', loginRoutes);

app.listen(port, () => {
  console.log(`Listener Server http://localhost:${port}`);
});