import express from 'express';
import ensureIsAuthenticated from '../helpers/authGuard';
import { signUp, login, create, findAll, findOne, remove, update } from '../controllers/userController';
let userRouter = express.Router();

userRouter.post('/signup', signUp);
userRouter.post('/login', login);

userRouter.post('/user', ensureIsAuthenticated, create);
userRouter.get('/user', findAll);
userRouter.get('/user/:id', findOne);
userRouter.put('/user/:id', ensureIsAuthenticated, update);
userRouter.delete('/user/:id', ensureIsAuthenticated, remove);

export default userRouter;
