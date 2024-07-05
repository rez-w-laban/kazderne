import { Avatar } from "@mui/material";
import React, { useEffect, useState } from "react";
import {
  deleteComment,
  getActivityComments,
} from "../helpers/activity.helpers";
import { formatDateToView, stringAvatar } from "../helpers/helpers";
import Lottie from "lottie-react";
import noResult from "../Assets/Lottie/noResult.json";
import SuccessMessageComponent from "./SuccessComponent";
import ErrorMessageComponent from "./ErrorComponent";
import { useNavigate } from "react-router-dom";

export const CommentsComponent = ({ activity_id, updateActivity }) => {
  const navigate = useNavigate();
  console.log(activity_id);
  const [comments, setComments] = useState([]);
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const clearMessage = () => {
    setErrorMessage("");
    setSuccessMessage("");
  };
  const getComments = async () => {
    try {
      const res = await getActivityComments({ activity_id });
      console.log(res);
      setComments(res.data.activity_comments);
    } catch (error) {
      console.log(error);
    }
  };

  const HandleDeleteComment = async (comment_id) => {
    try {
      const res = await deleteComment(comment_id);
      console.log(res);
      if (res.data.status === "success") {
        setSuccessMessage(res.data.message);
        getComments();
        updateActivity();
      } else {
        setErrorMessage(res.data.message);
      }
    } catch (error) {
      console.log(error);
    }
  };

  useEffect(() => {
    getComments();
  }, [activity_id]);

  return (
    <div className="flex flex-col items-center justify-center px-3 py-2 gap-3 max-h-[600px] overflow-auto">
      {comments.length === 0 ? (
        <div className="flex flex-col items-center justify-center text-gray-50 bg-slate-400 rounded-lg px-3 py-2">
          <Lottie animationData={noResult} loop={true} />
          <p>No Comments found</p>
        </div>
      ) : (
        comments.map((comment) => (
          <div
            key={comment?.id}
            className="flex flex-col items-start justify-center bg-white px-3 py-2 rounded-lg w-full shadow-sm text-sm gap-3"
          >
            <div className="flex items-center justify-between w-full">
              <div className="flex items-start justify-start gap-2">
                {comment?.user.profile_picture ? (
                  <Avatar
                    onClick={() => navigate(`/user/${comment?.user.id}`)}
                    className="shadow-lg cursor-pointer transition-all  hover:opacity-80"
                    src={`http://127.0.0.1:8000/api/profile_picture/${comment?.user.id}/${comment?.user?.profile_picture}`}
                  />
                ) : (
                  <Avatar
                    onClick={() => navigate(`/user/${comment?.user.id}`)}
                    className="shadow-lg cursor-pointer transition-all hover:opacity-80"
                    {...stringAvatar(comment?.user.name)}
                  />
                )}
                <div className="flex flex-col items-start justify-start">
                  <p
                    onClick={() => navigate(`/user/${comment?.user.id}`)}
                    className="font-bold cursor-pointer transition-all  border-transparent border-b-2 hover:border-black "
                  >
                    {comment?.user.name}
                  </p>
                  <p className="text-xs italic">
                    {formatDateToView(comment?.created_at)}
                  </p>
                </div>
                {}
              </div>
              <div className="flex justify-end items-center gap-2 flex-col">
                <button
                  onClick={() => HandleDeleteComment(comment?.id)}
                  className="px-2 py-1 bg-red-500 text-white text-xs hover:opacity-80 transition-all self-start active:opacity-50 rounded-full"
                >
                  remove
                </button>
              </div>
            </div>
            <div>{comment?.content}</div>
          </div>
        ))
      )}
      {errorMessage && (
        <ErrorMessageComponent
          message={errorMessage}
          clearMessage={clearMessage}
        />
      )}
      {successMessage && (
        <SuccessMessageComponent
          message={successMessage}
          clearMessage={clearMessage}
        />
      )}
    </div>
  );
};
