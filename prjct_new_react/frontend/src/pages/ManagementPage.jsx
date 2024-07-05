import React from "react";
import { Users } from "../components/Users";
import { Activities } from "../components/Activities";
import { Cities } from "../components/Cities";
import { Navbar } from "../components/Navbar";
import ActivityTypes from "../components/ActivityTypes";

export const ManagementPage = () => {
  return (
    <div className=" bg-gray-100 w-full min-h-screen h-full flex flex-col items-center justify-start ">
      <Navbar></Navbar>
      <div className="w-full flex items-center justify-center flex-col p-10 gap-5">
        <ActivityTypes />
        <Users />
        <Activities />
        <Cities />
      </div>
    </div>
  );
};
