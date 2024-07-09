import React, { useEffect, useState } from "react";
import Modal from "react-modal";
import { Avatar, modalClasses } from "@mui/material";
import { getUser } from "../helpers/user.helpers";
import { stringAvatar, stringAvatar1 } from "../helpers/helpers";
import axios from "axios";

import ModeCommentIcon from "@mui/icons-material/ModeComment";
import FavoriteIcon from "@mui/icons-material/Favorite";
import BookmarkAddedIcon from "@mui/icons-material/BookmarkAdded";
import StarIcon from "@mui/icons-material/Star";
import PinDropIcon from "@mui/icons-material/PinDrop";
import {
  adminUserSearch,
  deleteUser,
  getAllUsers,
  userPrivilege,
} from "../helpers/user.helpers";
import { useNavigate, useParams } from "react-router-dom";
import { Navbar } from "../components/Navbar";
import SuccessMessageComponent from "../components/SuccessComponent";
import ErrorMessageComponent from "../components/ErrorComponent";

const UserPage = () => {
  const user_id = useParams("user_id");
  console.log(user_id);
  const [activities, setActivities] = useState();
  const [user, setUser] = useState();
  const [aactivity, setAactivity] = useState();
  const [isLoading, setIsLoading] = useState(false);
  const [count, setCount] = useState();
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const clearMessage = () => {
    setErrorMessage("");
    setSuccessMessage("");
  };
  const navigate = useNavigate();

  const handleGetUser = async ({ user_id }) => {
    try {
      console.log(user_id);
      const res = await getUser(user_id);
      console.log(res);
      if (res.data.status === "success") {
        setActivities(res.data.user.activity);
        setUser(res.data.user);
        setCount(res.data.count);
      }
    } catch (error) {
      console.log(error);
    }
  };
  
  const promoteDemote = async (id) => {
    try {
      const res = await userPrivilege(id);
      console.log(res);
      if (
        res.data.message ===
        "Unauthorized : only Super admins can access this page"
      ) {
        setErrorMessage("only super admin can promote/demote users");
      }
      if (res.data.status === "success") {
        console.log(res.data);
        handleGetUser(user_id);
        setSuccessMessage(res.data.message);
      } else if (res.data.status === "failed") {
        setErrorMessage(res.data.message);
        console.log(res.data);
      }
    } catch (error) {
      //setErrorMessage(error.message)
      console.log(error);
    }
  };

  const handleDeleteUser = async () => {
    try {
      const res = await deleteUser(user_id);
      console.log(res);
      if (res.data.status === "failed") {
        setErrorMessage(res.data.message)
      }
      if (res.data.status === "success") {
        navigate(`/management`)
      }
    } catch (error) {
      console.log(error);
    }
  };

  useEffect(() => {
    console.log(user_id);
    handleGetUser(user_id);
  }, [user_id]);

  return (
    <div className="flex flex-col w-full justify-start items-center">
      <Navbar />
      <div className="flex flex-col justify-start gap-6 w-full rounded-lg min-h-screen h-full max-h-[750px] overflow-auto shadow-lg bg-slate-300 p-5">
        <div className="flex justify-between items-center">
          <h1>user info</h1>
        </div>
        <div className="flex justify-start gap-3 items-center ">
          {user?.profile_picture ? (
            <Avatar
              className="shadow-lg"
              sx={{ width: 120, height: 120 }}
              src={`http://127.0.0.1:8000/api/profile_picture/${user?.id}/${user?.profile_picture}`}
            />
          ) : (
            <Avatar className="shadow-lg" {...stringAvatar1(user?.name)} />
          )}

          <div className="flex flex-col justify-center">
            <p className="text-2xl font-bold">
              {user?.name}{" "}
              <span
                className="text-sm 
              font-extrabold"
              >
                (id:{user?.id})
              </span>
            </p>
            <p className="">{user?.email}</p>
            <div className="flex justify-start">
              <p
                className={
                  user?.role_id === 0
                    ? ` bg-yellow-700 uppercase text-xs text-white px-2 rounded-full mt-1 shadow-lg`
                    : (user?.role_id === 1) ?` bg-green-700 uppercase text-xs text-white px-2 rounded-full mt-1 shadow-lg ` : ` font-bold  text-xs ` 
                }
              >
                {user?.role_id === 0 ? "SUPER-ADMIN" : ( user?.role_id === 1 ?"ADMIN" : "USER" )}
              </p>
            </div>
            <div className="flex justify-start items-center  max-w-56  ">
                <p className="text-extrabold ">{user?.bio}</p>


            </div>
          </div>
        </div>
        <div className="flex justify-between items-center flex-wrap gap-4">
          <div className="flex items-center justify-start gap-4 text-sm">
            <div className="bg-gray-100 px-3 py-1 rounded-full">
              <span className=" font-bold">{user?.followed_count}</span>{" "}
              following
            </div>
            <div className="bg-gray-100 px-3 py-1 rounded-full">
              <span className=" font-bold">{user?.follower_count}</span>{" "}
              followers
            </div>
            <div className="bg-gray-100 px-3 py-1 rounded-full">
              <span className=" font-bold">{count?.activity_count}</span>{" "}
              Activities
            </div>
          </div>
          <div className="flex items-center justify-end gap-5">
            <button
              onClick={() => handleDeleteUser()}
              className="px-3 py-1 text-sm bg-red-600 text-white rounded-full hover:opacity-70 transition-all"
            >
              delete
            </button>
            <button
              onClick={() => promoteDemote(user?.id)}
              className={`px-2 py-1 text-white hover:opacity-70 active:opacity-50 text-sm rounded-full transition-all ${
                user?.role_id === 1 || user?.role_id === 0 ? "bg-red-500" : "bg-green-500"
              }`}
            >
              {user?.role_id === 1 || user?.role_id === 0  ? "demote" : "promote"}
            </button>
          </div>
        </div>
        <div className=" flex flex-col gap-2 justify-start">
          <div className="  border-y-2  border-gray-600"></div>
          <div className="">
            <h1 className="font-bold text-xl uppercase ">activities</h1>
          </div>
        </div>
        <div className="flex flex-wrap justify-start gap-3 ">
          {activities?.length === 0 ? (
            <div>no results </div>
          ) : (
            activities?.map((activity) => (
              <div
                onClick={() => {
                  navigate(`/activity/${activity?.id}`);
                }}
                key={activity?.id}
                className="relative gap-2 hover:shadow-2xl hover:opacity-85 text-gray-700 flex flex-col  h-72 bg-white hover:bg-yellow-600 hover:text-white rounded-md  w-52 overflow-hidden shadow-lg hover:scale-95 transition-all cursor-pointer"
              >
                <img
                  className=" w-52 object-cover aspect-square shadow-lg"
                  src={`http://127.0.0.1:8000/api/profile/${activity?.user_id}/${activity?.id}/${activity?.picture}`}
                  alt=""
                ></img>
                <div className="flex items-center justify-between">
                  <div className="flex items-end justify-start w-full px-2 gap-2">
                    <p className="text-lg font-bold">
                      {activity?.activity_name}
                    </p>
                  </div>
                </div>

                <div className="absolute flex justify-center items-center right-3 top-3 px-3 py-1  bg-white rounded-full text-yellow-400">
                  <StarIcon></StarIcon>
                  <p className="ml-1">{activity?.average_rate}</p>
                </div>

                <div className="flex items-center justify-evenly p-2 rounded-full bg-white mx-3">
                  <div className="flex items-center justify-center">
                    <FavoriteIcon className="text-red-600 shadow-sm"></FavoriteIcon>
                    <p className="text-sm text-red-600 shadow-sm">
                      {activity?.likes_count}
                    </p>
                  </div>
                  <div className="flex items-center justify-center">
                    <ModeCommentIcon className="text-gray-500 shadow-sm"></ModeCommentIcon>
                    <p className="text-sm text-gray-500 shadow-sm">
                      {activity?.comments_count}
                    </p>
                  </div>
                  <div className="flex items-center justify-center">
                    <BookmarkAddedIcon className="text-green-600 shadow-sm"></BookmarkAddedIcon>
                    <p className="text-sm text-green-600 shadow-sm">
                      {activity?.bookmarks_count}
                    </p>
                  </div>
                </div>
              </div>
            ))
          )}
        </div>
      </div>
      {successMessage && (
        <SuccessMessageComponent
          message={successMessage}
          clearMessage={clearMessage}
        />
      )}
      {errorMessage && (
        <ErrorMessageComponent
          message={successMessage ? successMessage : errorMessage}
          clearMessage={clearMessage}
        />
      )}
    </div>
  );
};

export default UserPage;
