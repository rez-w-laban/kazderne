import React, { useState, useEffect } from "react";
import Lottie from "lottie-react";
import SuccessLottie from "../Assets/Lottie/success.json";
import { X } from "lucide-react";

const SuccessMessageComponent = ({ message, clearMessage }) => {
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
    <div className=" fixed top-5 right-5 text-sm font-light p-3 rounded-lg bg-white text-green-700 flex items-center justify-between z-50 shadow-lg animate__animated animate__slideInDown ">
      <Lottie animationData={SuccessLottie} loop={false} className="w-8 h-8" />
      <p className="ml-2">{message}</p>
      <X
        className="w-4 ml-3 text-gray-500 hover:text-black transition-all cursor-pointer"
        onClick={() => clearMessage()}
      />
    </div>
  ) : null;
};

export default SuccessMessageComponent;
