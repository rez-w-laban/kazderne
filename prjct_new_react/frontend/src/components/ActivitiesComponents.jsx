import React, { useEffect, useState } from "react";
import "animate.css";
import Lottie from "lottie-react";
import noResult from "../Assets/Lottie/noResult.json";
import PinDropIcon from "@mui/icons-material/PinDrop";

import ModeCommentIcon from "@mui/icons-material/ModeComment";
import FavoriteIcon from "@mui/icons-material/Favorite";
import BookmarkAddedIcon from "@mui/icons-material/BookmarkAdded";
import StarIcon from "@mui/icons-material/Star";

import { useNavigate } from "react-router-dom";
const ActivitiesComponent = ({ activities }) => {
  useEffect(() => {}, [activities]);
  const navigate = useNavigate();
  return (
    <div className="flex flex-wrap justify-start gap-6  max-h-[600px]">
      {activities?.length === 0 ? (
        <div>no Activities </div>
      ) : (
        activities?.map((activity) => (
          <div
            onClick={() => navigate(`/activity/${activity?.id}`)}
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
                <p className="text-lg font-bold">{activity?.activity_name}</p>
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
                <p className="text-sm text-red-green shadow-sm">
                  {activity?.bookmarks_count}
                </p>
              </div>
            </div>
          </div>
        ))
      )}
    </div>
  );
};

export default ActivitiesComponent;
