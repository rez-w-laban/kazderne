import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { Avatar } from "@mui/material";
import { getMyProfile } from "../helpers/user.helpers";
import { stringAvatar } from "../helpers/helpers";
import { logout } from "../helpers/auth.helpers";
import ErrorMessageComponent from "./ErrorComponent";

export const Navbar = () => {
  const navigate = useNavigate();

  const [profile, setProfile] = useState();
  const [succesMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const clearMessage = () => {
    setErrorMessage("");
    setSuccessMessage("");
  };

  const getProfileInfo = async () => {
    try {
      const res = await getMyProfile();
      console.log(res);
      if (res.data.status === "success") {
        setProfile(res.data);
      } else {
        if (res.data.message === "Unauthorized , only for users") {
          navigate("/");
        }
      }
    } catch (error) {
      console.log(error);
    }
  };

  const logOut = async () => {
    try {
      const res = await logout();
      if (res.data.status === "success") {
        localStorage.clear();
        navigate("/login");
      } else {
        setErrorMessage(res.data.message);
      }
    } catch (error) {
      setErrorMessage(error);
    }
  };

  useEffect(() => {
    getProfileInfo();
  }, []);

  return (
    <div className=" flex p-3 px-5 w-full bg-gray-700 cursor-default shadow-lg items-center text-white justify-between gap-5">
      <div className="flex items-center justify-start w-full gap-2 ">
        {profile?.profile_picture ? (
          <Avatar
            src={`http://127.0.0.1:8000/api/profile_picture/${profile?.id}/${profile?.profile_picture}`}
          />
        ) : (
          profile && <Avatar {...stringAvatar(profile.name)} />
        )}
        <div className="flex flex-col text-sm">
          <p>{profile?.name}</p>
          <p className=" font-bold text-xs">{profile?.email}</p>
        </div>
      </div>
      <div className="w-full flex justify-center items-center gap-3 text-sm">
        <button
          className="btn bg-white transition-all text-gray-700 px-3 py-1 rounded-md hover:opacity-70"
          onClick={() => navigate("/management")}
        >
          Management
        </button>
      </div>
      <div className="w-full flex justify-end text-sm">
        <button
          onClick={() => logOut()}
          className="btn bg-red-500 text-white px-3 py-1 rounded-full hover:bg-white transition-all hover:text-red-600"
        >
          logout
        </button>
        <div className="absolute top-10 right-10 z-50">
          {errorMessage && (
            <ErrorMessageComponent
              message={errorMessage}
              clearMessage={clearMessage}
            />
          )}
        </div>
      </div>
    </div>
  );
};
