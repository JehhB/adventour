export type ToggleableProps = {
  active: boolean;
  toggle?(): void;
  open?(): void;
  close?(): void;
};
