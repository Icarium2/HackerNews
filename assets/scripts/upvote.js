function handleUpvote(upvoteSections, postName, phpPath) {
  upvoteSections.forEach((upvoteSection) => {
    const upvoteButton = upvoteSection.querySelector("button.upvoteBtn");
    const upvoteCount = upvoteSection.querySelector("p.upvotes");
    const buttonData = upvoteButton.dataset.id;

    upvoteButton.addEventListener("click", () => {
      if (!buttonData) {
        window.location.href = "/login.php";
      } else {
        const data = new FormData();
        data.append(postName, buttonData);

        const options = {
          method: "POST",
          body: data,
        };

        fetch(phpPath, options)
          .then((response) => response.json())
          .then((data) => {
            upvoteCount.textContent = data;
            upvoteButton.classList.toggle("active");
          });
      }
    });
  });
}

const commentUpvoteDivs = document.querySelectorAll("div.upvote.comment");
const postUpvoteDivs = document.querySelectorAll("div.upvote.post");

// for comments
if (commentUpvoteDivs) {
  handleUpvote(commentUpvoteDivs, "comment_id", "/app/comments/vote.php");
}

// for posts
if (postUpvoteDivs) {
  handleUpvote(postUpvoteDivs, "post_id", "/app/posts/vote.php");
}
