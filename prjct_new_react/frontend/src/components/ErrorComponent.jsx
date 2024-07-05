import Lottie from "lottie-react";
import React, { useState, useEffect } from "react";
import errorLottie from "../Assets/Lottie/error.json";
import { X } from "lucide-react";

const ErrorMessageComponent = ({ message, clearMessage }) => {
  const [visible, setVisible] = useState(true);

  useEffect(() => {
    const timer = setTimeout(() => {
      setVisible(false);
      clearMessage();
    }, 4000);

    return () => {
      clearTimeout(timer);
    };
  });

  return visible ? (
    <div className=" fixed top-20 right-20 text-sm font-light p-3 rounded-lg bg-white text-red-500 flex items-center justify-between z-50 shadow-xl animate__animated animate__slideInDown ">
      <Lottie animationData={errorLottie} loop={false} className="w-8 h-8" />
      <p className="text-sm ml-2 text-nowrap">{message}</p>
      <X
        className="w-4 ml-3 text-gray-500 hover:text-black transition-all cursor-pointer"
        onClick={() => clearMessage()}
      />
    </div>
  ) : null;
};

export default ErrorMessageComponent;
