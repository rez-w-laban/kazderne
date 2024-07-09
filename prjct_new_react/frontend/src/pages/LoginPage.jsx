import React from "react";
import LoginForm from "../components/LoginForm";
import Lottie from "lottie-react";
import LoginLottie from "../Assets/Lottie/login.json";

const LoginPage = () => {
  return (
    <div className="relative bg-gradient-to-r from-slate-500 to-white w-full flex-wrap-reverse h-screen flex items-center justify-center  p-10">
      <div className="flex-2 bg-[#E3E3E3] h-full w-fit rounded-2xl p-10 flex flex-col items-center justify-center">
        <h1 className="font-bold text-slate-500 text-3xl self-start">Login</h1>
        <p className="text-sm text-gray-500 self-start mt-2">
          Enter your email and password in order to sign in
        </p>
        <LoginForm />
      </div>
      <div className=" flex-1 flex items-center justify-center pl-10 text-white">
        <Lottie
          className="min-w-72 w-1/2"
          animationData={LoginLottie}
          loop={true}
        />
      </div>
    </div>
  );
};

export default LoginPage;
