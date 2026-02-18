import { useState } from "react";
import { Link } from "react-router-dom";

const Navbar = () => {
  const [toggleMenu, setToogleMenu] = useState(true);

  if (!toggleMenu) {
    return (
      <button
        onClick={() => setToogleMenu(!toggleMenu)}
        className="hover:cursor-pointer hover:bg-gray-700 py-4 px-2 rounded mr-2 transition"
      >
        <div className="px-2 *:m-1">
          <div className="border px-2"></div>
          <div className="border px-2"></div>
          <div className="border px-2"></div>
        </div>
      </button>
    );
  } else {
    return (
      <div className="flex flex-col fixed right-0 bottom-0 top-0 bg-gray-500 py-5 px-2">
        <button
          className="hover:cursor-pointer hover:bg-gray-700 py-4 px-2 rounded mr-2 transition"
          onClick={() => setToogleMenu(!toggleMenu)}
        >
          <div className="px-2 m-5">
            <div className="border px-2 rotate-45"></div>
            <div className="border px-2 rotate-135"></div>
          </div>
        </button>
        <nav className="flex flex-col justify-between  py-5 px-2 *:hover:bg-gray-500">
          <Link to="/">Home</Link>
          <Link to="/">Home</Link>
          <Link to="/">Home</Link>
          <Link to="/">Home</Link>
          <Link to="/">Home</Link>
          <Link to="/">Home</Link>
          <Link to="/">Home</Link>
          <Link to="/">Home</Link>
          <Link to="/">Home</Link>
          <Link to="/">Home</Link>
        </nav>
      </div>
    );
  }
};

export default Navbar;
