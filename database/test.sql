-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Jun-2021 às 18:17
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `test`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `zipcode` varchar(10) CHARACTER SET utf8 NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 NOT NULL,
  `number` varchar(10) CHARACTER SET utf8 NOT NULL,
  `complement` varchar(30) CHARACTER SET utf8 NOT NULL,
  `district` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city` varchar(50) CHARACTER SET utf8 NOT NULL,
  `state` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `zipcode`, `address`, `number`, `complement`, `district`, `city`, `state`) VALUES
(7, 3, '18899000', 'Teste treasda sdas', 'Teste trea', 'Teste trea', 'Teste treasda sdas', 'Teste treasda sdas', 'Teste treasda sdas'),
(8, 3, '1890000', 'Endereço teste', 'Número tes', 'Complement', 'Bairro teste', 'Cidade teste', 'Estado teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `cellphone` varchar(15) DEFAULT NULL,
  `borndate` date DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `telephone`, `cellphone`, `borndate`, `comments`, `type`, `status`) VALUES
(1, 'Rogerio de Paula Ferreira', 'rogeriodepaulaferreira@gmail.com', '14 982105077', '14 982105077', '1992-02-04', 'teste teste', 1, 1),
(3, 'asdasd', 'teste@teste.com.br', '1433224547', '', '1990-02-04', 'teste', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fornecedor_id` int(11) NOT NULL,
  `colaborador_id` int(11) NOT NULL,
  `observacoes` text CHARACTER SET utf8 NOT NULL,
  `finalizado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `fornecedor_id`, `colaborador_id`, `observacoes`, `finalizado`) VALUES
(4, 3, 1, ' Quisque vitae nibh luctus, cursus nulla eu, elementum felis. Nullam a est vel magna sagittis consequat. In et efficitur magna. Fusce semper ipsum tempor dignissim ultrices.', 0),
(5, 3, 1, 'Teste teste teste', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders_itens`
--

CREATE TABLE `orders_itens` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `value` float NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `orders_itens`
--

INSERT INTO `orders_itens` (`id`, `order_id`, `product_id`, `value`, `quantidade`) VALUES
(8, 4, 1, 6000, 10),
(9, 4, 2, 100, 100),
(10, 5, 3, 11555.2, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `description`, `status`) VALUES
(1, '10G-P5-3885-KR', 'Placa de vídeo Nvidia Evga XC Gaming GeForce RTX 30 Series RTX 3080 10GB', 'A Nvidia é o fabricante líder de placas de vídeo, sua qualidade garante uma experiência positiva no desenvolvimento do motor gráfico do seu computador. Além disso, seus processadores usam tecnologia de ponta para que você possa desfrutar de um produto rápido e durável.\r\n\r\nNo menor tempo possível\r\nCom uma velocidade de memória de 19000 MHz os dados do processador central serão traduzidos em informação compreensível em apenas um piscar de olhos, ele decodificará tantos ciclos por segundo que tornará a transmissão de dados para outros componentes mais eficazes. Com esta qualidade, o equipamento ganhará agilidade e eficiência.\r\n\r\nVelocidade em cada leitura\r\nPossui 8704 núcleos, portanto a interface de sua placa será algo surpreendente. Este tipo de estrutura é adequada para o processamento de tecnologias mais complexas e modernas caracterizadas por grandes volumes de dados.\r\n\r\nQualidade de imagem\r\nCritério fundamental na escolha uma placa de vídeo, a sua resolução de 7680x4320 não irá decepcioná-lo. A decodificação dos píxeis na sua tela fará com que você veja até os menores detalhes em cada ilustração.', 1),
(2, '#002', 'Produto 2 testeteste', 'teste', 1),
(3, '#003', 'Produto 3 teste', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `user`, `pass`) VALUES
(1, 'admin', 'admin');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_customer` (`customer_id`);

--
-- Índices para tabela `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `orders_itens`
--
ALTER TABLE `orders_itens`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `orders_itens`
--
ALTER TABLE `orders_itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
