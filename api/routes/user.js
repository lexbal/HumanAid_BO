import express from 'express';
import multer from "multer";
import moment from 'moment';
import ensureIsAuthenticated from '../helpers/authGuard.js';
import { signUp, login, create, mail, findOne, remove, update } from '../controllers/userController.js';
let userRouter = express.Router();
var storage = multer.diskStorage(
  {
    destination: 'public/uploads',
    filename: function (req, file, cb) {
      cb(null, moment().format('YYYY-MM-DD_HH:mm:ss') + '-' +file.originalname)
    }
  }
);
var upload = multer({ storage });

userRouter.post('/signup', upload.single('file'), signUp);
userRouter.post('/login', login);

userRouter.post('/send_mail', mail);

userRouter.post('/user', ensureIsAuthenticated, create);
userRouter.get('/user/:id', findOne);
userRouter.put('/user/:id', ensureIsAuthenticated, update);
userRouter.delete('/user/:id', ensureIsAuthenticated, remove);

export default userRouter;
