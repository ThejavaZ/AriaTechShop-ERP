import Navbar from "./navbar";

const Header = () => {
  return (
    <>
      <header className="flex justify-between py-5 bg-gray-500">
        <h1>Aria Tech Shop</h1>
        <Navbar />
      </header>
    </>
  );
};

export default Header;
