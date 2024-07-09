import "./App.css";
import LoginPage from "./pages/LoginPage";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import { ManagementPage } from "./pages/ManagementPage";
import UserPage from "./pages/UserPage";
import ActivityPage from "./pages/ActivityPage";
import CityPage from "./pages/CityPage";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<LoginPage />} />
        <Route path="/login" element={<LoginPage />} />
        <Route path="/management" element={<ManagementPage />} />
        <Route path="/user/:user_id" element={<UserPage />} />
        <Route path="/activity/:activity_id" element={<ActivityPage />} />
        <Route path="/city/:city_id" element={<CityPage />} />
      </Routes>
    </Router>
  );
}

export default App;
