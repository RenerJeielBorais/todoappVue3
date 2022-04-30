
CREATE TABLE `todo` (
  `id` int(12) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `todo` (`id`, `title`, `description`, `status`) VALUES
(1, 'Todo', 'create todoapp', 'Active');

ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;