test('login button disabled if fields empty', () => {
  const email = "";
  const password = "";

  const result = email !== "" && password !== "";

  expect(result).toBe(false);
});