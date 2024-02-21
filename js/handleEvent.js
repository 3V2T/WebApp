export default function handleEvent() {
  return {
    handleToggleHeartIcon: (event, userId, bookId) => {
      event.preventDefault();
      const element = event.target;
      element.classList.toggle("active");
      if (element.classList.contains("active")) {
        console.log({ userId, bookId });
        element.classList.add("fa-solid");
        element.classList.remove("fa-regular");
        fetch(
          `/WebApp/controller/wishListHandle.php?action=add&userId=${userId}&&bookId=${bookId}`,
          () => {}
        )
          .then((res) => {
            console.log(res);
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        element.classList.remove("fa-solid");
        element.classList.add("fa-regular");
        fetch(
          `/WebApp/controller/wishListHandle.php?action=remove&userId=${userId}&&bookId=${bookId}`,
          () => {}
        )
          .then((res) => {
            console.log(res);
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
  };
}
