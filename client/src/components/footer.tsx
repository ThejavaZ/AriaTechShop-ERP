const Footer = () => {
  const date = new Date();
  return (
    <>
      <footer>
        <p>&copy; Copyright derechos reservados {date.getFullYear()}</p>
      </footer>
    </>
  );
};

export default Footer;
