import { ThemeContext, ThemeProvider } from "./theme";

export const providers = [ThemeProvider];

export const Providers = ({ children }) => {
  return providers.reduce(
    (acc, Provider) => <Provider>{acc}</Provider>,
    children
  );
};
