import React, { useEffect, useState } from "react";
import Modal from "react-modal";
import { Avatar, modalClasses } from "@mui/material";
import { getUser } from "../helpers/user.helpers";
import { stringAvatar, stringAvatar1 } from "../helpers/helpers";
import axios from "axios";
import "animate.css";

import CommentIcon from "@mui/icons-material/Comment";
import InsertPhotoIcon from "@mui/icons-material/InsertPhoto";
import FavoriteIcon from "@mui/icons-material/Favorite";
import PinDropIcon from "@mui/icons-material/PinDrop";
import MediaComponent from "../components/MediaComponent";
import { LikesComponent } from "../components/LikesComponent";
import { CommentsComponent } from "../components/CommentsComponent";
import { MapPin, StarIcon, X } from "lucide-react";
import { deleteActivity, getActivity } from "../helpers/activity.helpers";
import SuccessMessageComponent from "../components/SuccessComponent";
import { Navbar } from "../components/Navbar";
import { useNavigate, useParams } from "react-router-dom";
import RatingComponent from "../components/RatingsComponent";
import RatingsComponent from "../components/RatingsComponent";

const falseState = {
  media: false,
  likes: false,
  comments: false,
  ratings: false,
};

const ActivityPage = () => {
  const { activity_id } = useParams("activity_id");
  const [state, setState] = useState({
    media: true,
    likes: false,
    comments: false,
    ratings: false,
  });
  const togglePage = (page) => {
    setState({ ...falseState, [page]: true });
  };
  const [activityPictures, setActivityPictures] = useState();
  const [activity, setActivity] = useState({});
  const [isLoading, setIsLoading] = useState(false);
  const [mainImage, setMainImage] = useState("");

  const handleGetActivity = async () => {
    try {
      const res = await getActivity({ activity_id });
      //  console.log(res);
      if (res.data.status === "success") {
        setActivity(res.data.activity);
        setActivityPictures(activity?.activity_pictures);
        setMainImage(activity?.activity_pictures[0]?.media);
        // console.log(activity);
      }
    } catch (error) {
      console.log(error);
    }
  };
  const navigate = useNavigate();

  const handleDeleteActivity = async () => {
    try {
      console.log(activity_id);
      const res = await deleteActivity({ activity_id });
      console.log(res);
      if (res.data.status === "success") {
        // setSuccessMessage(res.data.message);
        navigate(`/management`);
      }
    } catch (error) {
      console.log(error);
    }
  };

  useEffect(() => {
    handleGetActivity();
  }, [activity_id?.id]);

  const { media, likes, comments, ratings } = state;

  return (
    <div className="w-full flex flex-col items-center justify-start">
      <Navbar />

      <div className=" relative  flex flex-col  justify-start gap-6 w-full rounded-lg min-h-screen h-full shadow-lg bg-slate-300 p-8 overflow-auto scroll-smooth ">
        <div className="relative flex  justify-center mt-12  ">
          <img
            className="h-[300px]  w-full object-cover aspect-square rounded-md shadow-md"
            src={`http://127.0.0.1:8000/api/profile/${activity?.user?.id}/${activity?.id}/${activity?.picture}`}
            alt=""
          />
          <div className=" flex justify-center  absolute  top-3/4 ">
            {activity?.user?.profile_picture ? (
              <Avatar
                onClick={() => navigate(`/user/${activity?.user?.id}`)}
                className="shadow-xl border-2 border-slate-300  hover:opacity-80 transition-all cursor-pointer"
                sx={{ width: 120, height: 120 }}
                src={`http://127.0.0.1:8000/api/profile_picture/${activity?.user?.id}/${activity?.user?.profile_picture}`}
              />
            ) : (
              <Avatar
                onClick={() => navigate(`/user/${activity?.user?.id}`)}
                className="shadow-xl border-2 border-slate-300 hover:opacity-80 transition-all cursor-pointer"
                {...stringAvatar1(activity?.user?.name)}
              />
            )}
          </div>
        </div>

        <div className="flex flex-col gap-5 justify-Start mt-4">
          <div className="flex justify-between">
            <div className="flex flex-col  sticky">
              <div className="flex items-center justify-start gap-3">
                <h1 className="   text-2xl font-bold  ">
                  {activity?.activity_name}{" "}
                </h1>
                <h1 className="  text-sm  text-gray-800 ">
                  ( id : {activity?.id} )
                </h1>{" "}
              </div>
              <h1 className="   text-sm text-gray-800 ">
                By {activity?.user?.name}
              </h1>
            </div>
            <div className="flex text-center items-center">
              <button
                onClick={() => handleDeleteActivity()}
                className=" p-1 bg-red-500 rounded-lg text-white text-sm transition-all hover:opacity-80 "
              >
                delete
              </button>{" "}
            </div>
          </div>
          <p className="   text-xs text-black">{activity?.description} </p>
          <div className="flex items-center justify-start py-2 ">
            <MapPin className="w-4"></MapPin>
            <p
              onClick={() => navigate(`/city/${activity?.city?.id}`)}
              className=" ml-2 text-black font-mono border-b-2 border-slate-300 hover:border-black transition-all cursor-pointer "
            >
              {activity?.city?.city_name}
            </p>
          </div>
          <div className="flex gap-4  justify-evenly items-center  ">
            <div
              onClick={() => togglePage("media")}
              className={
                media
                  ? `flex w-full px-3 py-1 hover:bg-white rounded-sm transition-all cursor-pointer justify-center items-center gap-1  text-gray-700 border-b-4 border-white`
                  : `flex w-full px-3 py-1 hover:bg-white rounded-sm transition-all cursor-pointer justify-center items-center gap-1  text-gray-700`
              }
            >
              <InsertPhotoIcon />
              <h1 className="text-md">{activity?.activity_pictures_count}</h1>
            </div>
            <div
              onClick={() => togglePage("likes")}
              className={
                likes
                  ? `flex px-3 w-full py-1 hover:bg-red-500  hover:text-white rounded-sm transition-all cursor-pointer justify-center items-center gap-1  text-gray-700 border-b-4 border-red-500`
                  : `flex px-3 w-full py-1 hover:bg-red-500  hover:text-white rounded-sm transition-all cursor-pointer justify-center items-center gap-1  text-gray-700`
              }
            >
              <FavoriteIcon />
              <h1 className="text-md">{activity?.likes_count}</h1>
            </div>

            <div
              onClick={() => togglePage("comments")}
              className={
                comments
                  ? `flex px-3 w-full py-1 hover:bg-gray-500  hover:text-white rounded-sm transition-all cursor-pointer justify-center items-center gap-1  text-gray-700 border-b-4 border-gray-500`
                  : `flex px-3 w-full py-1 hover:bg-gray-500  hover:text-white rounded-sm transition-all cursor-pointer justify-center items-center gap-1  text-gray-700`
              }
            >
              <CommentIcon />
              <h1 className="text-md">{activity?.comments_count}</h1>
            </div>

            <div
              onClick={() => togglePage("ratings")}
              className={
                ratings
                  ? `flex px-3 w-full py-1 hover:bg-yellow-600  hover:text-white rounded-sm transition-all cursor-pointer justify-center items-center gap-1  text-gray-700 border-b-4 border-yellow-600`
                  : `flex px-3 w-full py-1 hover:bg-yellow-600  hover:text-white rounded-sm transition-all cursor-pointer justify-center items-center gap-1  text-gray-700`
              }
            >
              <StarIcon />
              <h1 className="text-md">{activity?.rate_count}</h1>
            </div>
          </div>
          {media && <MediaComponent activity={activity}></MediaComponent>}
          {likes && (
            <LikesComponent activity_id={activity?.id}></LikesComponent>
          )}
          {comments && (
            <CommentsComponent
              activity_id={activity?.id}
              updateActivity={handleGetActivity}
            ></CommentsComponent>
          )}
          {ratings && (
            <RatingsComponent
              activity_id={activity?.id}
              updateActivity={handleGetActivity}
            ></RatingsComponent>
          )}
        </div>
      </div>
    </div>
  );
};

export default ActivityPage;
